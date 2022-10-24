<?php

namespace App\Console\Commands;

use App\Models\ArticleRecord;
use App\Models\Author;
use App\Models\History;
use App\Models\Repository;
use App\Models\Subject;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;


class Harvest extends Command
{
    private $repository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Harvest:Repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->countRecord = 1;
        $id = $this->ask('Journal ID?');
        $repository = Repository::where('id', $id)->first();
        $verb = '/oai?verb=ListRecords';
        $protocol = 'oai_dc';
        $set = $repository->abbreviation;
        $from = $this->ask('Harvest From Date?');
        $until = $this->ask('Harvest Until Date?');
        
        if(empty($until))
            $until = Carbon::now()->format('Y-m-d');

        $url = $repository->baseURL . $verb . "&metadataPrefix=" . $protocol . "&set=" . $set . '&from=' . $from . '&until=' . $until;

        if (empty($from)) {
            $url = $repository->baseURL . $verb . "&metadataPrefix=" . $protocol . "&set=" . $set;
        }
       
        $client = new Client(array(
                'CURLOPT_URL' =>  $url,
                'CURLOPT_RETURNTRANSFER' =>  1,
                'CURLOPT_SSL_VERIFYPEER' =>  false,
                'CURLOPT_FOLLOWLOCATION' =>  true,
                'CURLOPT_FAILONERROR' =>  0,
                'CURLOPT_USERAGENT' =>  'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6',
            )
        );
        $response = $client->request('GET', $url);

        if($response->getstatusCode() === 200){
            $html = $response->getBody();

            $xml = new SimpleXMLElement($html);
            if ($protocol == 'oai_dc') {
                $listRecords = $this->format_OAIDC($repository, $xml);
            } else {
                $listRecords = [];
            }

            if (count($listRecords) != 0) {
                echo "Get " . $this->countRecord . " - " . (count($listRecords) + $this->countRecord - 1)  . " \n";
                $this->countRecord = $this->countRecord + count($listRecords);
            }

            if (!empty((string)$xml->ListRecords->resumptionToken) && (string)$xml->ListRecords->resumptionToken != '') {
                $listRecords = array_merge($listRecords, $this->iteratorListRecords((string)$xml->ListRecords->resumptionToken, $protocol, $repository));
            }

            $result['results'] = $listRecords;
        }else{
            Log::error("Can't Harvest this Journal. Try Again!");
        }

        echo "Successfully Harvest Articles, Total Records ".count($result['results'])."\n";

        History::create([
            'repoId' => $repository->id,
            'from' => $from,
            'until' => $until,
            'address' => '66.102.0.0',
            'listRecords' => count($result['results']),
            'countRecords' => $this->countRecord - 1,
        ]);

        return $result['results'];
    }

    public function iteratorListRecords($token, $protocol, $repository)
    {
        $url = $repository->baseURL .'/oai' ."?verb=ListRecords&resumptionToken=" . $token;

        $client = new Client(array(
            'CURLOPT_URL' =>  $url,
            'CURLOPT_RETURNTRANSFER' =>  1,
            'CURLOPT_SSL_VERIFYPEER' =>  false,
            'CURLOPT_FOLLOWLOCATION' =>  true,
            'CURLOPT_FAILONERROR' =>  0,
            'CURLOPT_USERAGENT' =>  'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6',
            )
        );
        $response = $client->request('GET', $url);

        if($response->getstatusCode() === 200){
            $html = $response->getBody();

            $xml = new SimpleXMLElement($html);
            if ($protocol == 'oai_dc') {
                $listRecords = $this->format_OAIDC($repository, $xml);
            } else {
                $listRecords = [];
            }

            if (count($listRecords) != 0) {
                echo "Get " . $this->countRecord . " - " . (count($listRecords) + $this->countRecord - 1)  . " \n";
                $this->countRecord = $this->countRecord + count($listRecords);
            }

            if (!empty((string)$xml->ListRecords->resumptionToken) && (string)$xml->ListRecords->resumptionToken != '') {
                $listRecords = array_merge($listRecords, $this->iteratorListRecords((string)$xml->ListRecords->resumptionToken, $protocol, $repository));
            }

            $result['results'] = $listRecords;

        }else{
            Log::error("Can't Harvest this Journal. Try Again!");
        }

        return $result['results'];
    }

    public function format_OAIDC($repository, $xml)
    {
        $nsUriOaiDc = 'http://www.openarchives.org/OAI/2.0/oai_dc/';
        $nsUriOaiDc2 = 'https://www.openarchives.org/OAI/2.0/oai_dc/';

        $records = $xml->ListRecords->record;
        $i =0;
        $return = [];

        if(!empty($records))
        {
            foreach($records as $record)
            {
                $return[$i]['identifier'] = (string)$record->header->identifier;
                $return[$i]['status'] = (string)$record->header->attributes()->{"status"};                     

                if($return[$i]['status'] != 'deleted'){
                    $metadata = $record->metadata->children($nsUriOaiDc)->asXml(); 
                    if (!$metadata) {
                        $metadata = $record->metadata->children($nsUriOaiDc2)->asXml(); 
                    }
                    

                    $dom = new DOMDocument();
                    $dom->loadXML($metadata);
                                    
                    $xpath = new DOMXPath($dom);

                    $title = $xpath->query('//dc:title');
                    $creator = $xpath->query('//dc:creator');
                    $subject = $xpath->query('//dc:subject');
                    $description = $xpath->query('//dc:description');
                    $publisher = $xpath->query('//dc:publisher');
                    $contributor = $xpath->query('//dc:contributor');
                    $date = $xpath->query('//dc:date');
                    $type = $xpath->query('//dc:type');
                    $format = $xpath->query('//dc:format');
                    $identifier = $xpath->query('//dc:identifier');
                    $source = $xpath->query('//dc:source');
                    $language = $xpath->query('//dc:language');
                    $relation = $xpath->query('//dc:relation');
                    $coverage = $xpath->query('//dc:coverage');
                    $rights = $xpath->query('//dc:rights');

                    // Title
                    if (!empty($title) && $title->length != 0) {
                        foreach ($title as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['title'] = (string)$node->nodeValue;
                            }
                        }
                    }

                    // Authors
                    $x = 0;
                    $return[$i]['creators'] = [];
                    if (!empty($creator) && $creator->length != 0) {
                        foreach ($creator as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $au = explode(";", $node->nodeValue);
                                $aff = !empty($au[1]) ? $au[1] : "";
                                $name = explode(', ', (string)($au[0]));
                                $return[$i]['creators'][$x]['firstname'] = (string)($name[1]);
                                $return[$i]['creators'][$x]['lastname'] = (string)($name[0]);
                                $return[$i]['creators'][$x]['affiliations'] = (string)($aff);
                                $return[$i]['creators'][$x]['email'] = '';

                                $x++;
                                
                            }
                        }
                    }

                    // Subject
                    $x = 0;
                    $return[$i]['subjects'] = [];
                    if (!empty($subject) && $subject->length != 0) {
                        foreach ($subject as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['subject'] = str_replace(',', ';', $node->nodeValue);   
                                $return[$i]['subjects'] = explode('; ',  $return[$i]['subject']);   
                            }
                        }
                    }
                    
                    // Description
                    if (!empty($description) && $description->length != 0) {
                        foreach ($description as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['description'] = (string)$node->nodeValue;
                            }
                        }
                    }

                    // Publisher
                    if (!empty($publisher) && $publisher->length != 0) {
                        foreach ($publisher as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['publisher'] = (string)$node->nodeValue;
                            }
                        }
                    }

                    if(!empty($source && $source->length != 0))
                    {
                        foreach($source as $node)
                        {
                            if (!is_numeric(substr($node->nodeValue, 0, 4))) {
                                $source_text = (string)($node->nodeValue);
                            }
                        }

                        if(!empty($source_text)){
                            $source = explode('; ', $source_text);

                            // repoTitle
                            if(!empty($source[0]))
                            {
                                $return[$i]['repoTitle'] = (string)($source[0]);
                                
                            }
                            // issue
                            if(!empty($source[1]))
                            {
                                $issue = explode(' ', (string)($source[1]));
                                $return[$i]['issue'] = (string)($source[1]);
                                $vol = explode(',', (string)($issue[1]));
                                $return[$i]['volume'] = (string)($vol[0]);
                                $return[$i]['volume'] = (string)($vol[0]);
                                
                                $no = explode(':', (string)($issue[3]));
                                $return[$i]['nomor'] = (string)($no[0]);
                            }
                            // pages
                            if(!empty($source[2]))
                            {
                                $return[$i]['pages'] = (string)($source[2]);
                                
                            }
                            
                        }
                    }

                    if(!empty($date && $date->length != 0))
                    {
                        foreach($date as $node)
                        {
                            $return[$i]['date'] = (string)($node->nodeValue);
                            
                        }

                        $match = explode('-', $return[$i]['date']);
                        // year
                        if(!empty($match[0]))
                        {
                            $return[$i]['year'] = (string)($match[0]);
                        }

                    }

                    if(!empty($identifier && $identifier->length != 0))
                    {
                        foreach($identifier as $node)
                        {
                            // doi
                            if (substr($node->nodeValue, 0, 3) == '10.') {
                                $return[$i]['doi'] = $node->nodeValue;
                            }
                        }
                    }

                    // Format
                    if (!empty($format) && $format->length != 0) {
                        foreach ($format as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['format'] = (string)$node->nodeValue;
                                
                                if($return[$i]['format'] === 'application/pdf'){
                                    if (!empty($relation) && $relation->length != 0) {
                                        if (substr($relation[0]->nodeValue, 0, 7) == 'http://' || substr($relation[0]->nodeValue, 0, 8) == 'https://' ) {
                                                
                                            $return[$i]['url'] = str_replace('/view/', '/download/', $relation[0]->nodeValue);  

                                            $directory = storage_path('app/public/PDF/'.$repository->abbreviation);
                    
                                            if(!File::isDirectory($directory)){
                
                                                File::makeDirectory($directory, 0777, true, true);
                                        
                                            }
                                        

                                            $splitName = explode('/', $return[$i]['identifier']);

                                            $fileName = $repository->abbreviation.'-'.$splitName[1].'.pdf';
                                            $handle = fopen($directory.'/'.$fileName, 'w+');

                                            $client = new Client(array(
                                                'base_uri' => '',
                                                'verify' => false,
                                                'sink' => $handle,
                                                'curl.options' => array(
                                                    'CURLOPT_RETURNTRANSFER' => 1,
                                                    'CURLOPT_FILE' => $handle,
                                                    'CURLOPT_SSL_VERIFYPEER' =>  false,
                                                    'CURLOPT_FOLLOWLOCATION' =>  true,
                                                    'CURLOPT_FAILONERROR' =>  0,
                                                    'CURLOPT_USERAGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36'
                                                )
                                            ));

                                            $response = $client->get($return[$i]['url']);
                                            fclose($handle);

                                            $return[$i]['file_PDF'] = 'public/PDF/'.$repository->abbreviation.'/'.$fileName;
                                            
                                        } 
                                    }
                                }
                            }
                        }
                    }

                    $article = ArticleRecord::updateOrCreate(['repoId' => $repository->id, 'identifier' => $return[$i]['identifier']],[
                        'title' => $return[$i]['title'],
                        'description' => $return[$i]['description'],
                        'publisher' => $return[$i]['publisher'],
                        'repoTitle' => $return[$i]['repoTitle'],
                        'issue' => !empty($return[$i]['issue']) ? $return[$i]['issue'] : null,
                        'volume' => !empty($return[$i]['volume']) ? $return[$i]['volume'] : null,
                        'nomor' => !empty($return[$i]['nomor']) ? $return[$i]['nomor'] : null,
                        'pages' => !empty($return[$i]['pages']) ? $return[$i]['pages'] : null,
                        'date' => !empty($return[$i]['date']) ? $return[$i]['date'] : null,
                        'year' => !empty($return[$i]['year']) ? $return[$i]['year'] : null,
                        'doi' => !empty($return[$i]['doi']) ? $return[$i]['doi'] : null,
                        'file_PDF' => !empty($return[$i]['file_PDF']) ? $return[$i]['file_PDF'] : null,
                    ]);

                    $authors = Author::where(['article_id' => $article->id])->get();

                    
                    if($authors === array(0)){
                        foreach($return[$i]['creators'] as $author)
                        {
                            Author::create([
                                'article_id' => $article->id,
                                'firstname' => $author['firstname'],
                                'lastname' => $author['lastname'],
                                'affiliations' => $author['affiliations'],
                                'email' => $author['email'],
                            ]);
                        }
                    }else{
                        Author::where(['article_id' => $article->id])->delete();

                        foreach($return[$i]['creators'] as $author)
                        {
                            Author::create([
                                'article_id' => $article->id,
                                'firstname' => $author['firstname'],
                                'lastname' => $author['lastname'],
                                'affiliations' => $author['affiliations'],
                                'email' => $author['email'],
                            ]);
                        }
                    }

                    $subjects = Subject::where(['article_id' => $article->id])->get();

                    if($subjects === array(0)){
                        if(!empty($return[$i]['subjects']))
                        {
                            foreach($return[$i]['subjects'] as $subject)
                            {
                                Subject::create([
                                    'article_id' => $article->id,
                                    'subject' => !empty($subject) ? $subject : '',
                                ]);
                            }
                        }
                        
                    }else{
                        Subject::where(['article_id' => $article->id])->delete();
                        if(!empty($return[$i]['subjects']))
                        {
                            foreach($return[$i]['subjects'] as $subject)
                            {
                                Subject::create([
                                    'article_id' => $article->id,
                                    'subject' => !empty($subject) ? $subject : '',
                                ]);
                            }
                        }
                    }
                    
                }   

                echo 'Success Upload Article '.'-> '.$i + (1).'. '. $return[$i]['title']. " \n";

                $i++;
            }
        }
        return $return;
    }
}
