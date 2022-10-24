<?php

namespace App\Http\Livewire\Backend\Admin;

use App\Models\ArticleRecord;
use App\Models\Author;
use App\Models\History;
use App\Models\Repository;
use App\Models\Subject;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithPagination;
use SimpleXMLElement;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;

class RepositoryDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    
    public $paginate= 10;
    public $sortBy = 'id';
    public $search = '';
    public $sortDirection = 'asc';
    public $repository;
    public $responseDate;
    public $request;
    public $listSet = [];
    public $abbreviation;
    public $responseDateRecord;
    public $protocol;
    public $from;
    public $until;
    public $set;
    public $countRecord;
    public $title;
    public $description;
    public $issue;
    public $volume;
    public $nomor;
    public $pages;
    public $doi;
    public $file_PDF;
    public $articleId;
    public $EditModal = false;

    public function mount($id)
    {
        $this->repository = Repository::where(['id' => $id])->first();
        $this->countRecord = 0;
        $from = History::where(['repoId' => $id])->orderBy('created_at', 'desc')->first();
           if(!empty($from))
           {
                $this->from = Carbon::parse($from->until)->format('Y-m-d');
           }else{
               $this->from = 2000-01-01;
           }
    }

    public function render()
    {
        $articles = ArticleRecord::query()->search($this->search)->where(['repoId' => $this->repository->id])->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.backend.admin.repository-detail' ,compact('articles'))
        ->extends('layouts.Be')
        ->section('content');
    }

    public function history()
    {
        $role = Auth::user()->roles->implode('name');
        if($role === 'Administrator')
        {
            return redirect()->route('admin.history', $this->repository->abbreviation);
        }else{
            return redirect()->route('assistent.history', $this->repository->abbreviation);
        }
    }
    public function sortBy($field)
    {
        if($this->sortDirection == 'asc'){
            $this->sortDirection = 'desc';
        } else{
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function resetFill()
    {
        $this->articleId = '';
        $this->title = '';
        $this->description = '';
        $this->issue ='';
        $this->volume = '';
        $this->nomor = '';
        $this->pages = '';
        $this->doi = '';
        $this->file_PDF = '';
    }
    public function getListSet()
    {
        $verb = '/oai?verb=ListSets';
        $client = new Client([$this->repository->baseURL.$verb]);
        $response = $client->request('GET', $this->repository->baseURL.$verb);

        if($response->getstatusCode() === 200)
        {
            $html = $response->getBody();
            $dom = new SimpleXMLElement($html);
            $this->responseDate = (string)($dom->responseDate);
            $this->request = (string)($dom->request);
            $listSet = [];
            $i = 0;
            foreach ($dom->ListSets->set as $set) {
                $listSet[$i]['setSpec'] = (string) $set->setSpec;
                $listSet[$i]['setName'] = (string) $set->setName;
                $i++;
            }
            $this->listSet = $listSet;
        }
    }

    public function storeAbbreviation()
    {
        Repository::updateOrCreate(['id' => $this->repository->id],[
            'abbreviation' => $this->abbreviation,
        ]);

        $this->alert('success', 'Abbreviation Updated Successfully', [
            'position' =>  'center', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Close', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  false, 
            'cancelButtonColor' => '#EF4444'
        ]);
    }

    public function getListRecords()
    {
        $verb = '/oai?verb=ListRecords';
        $protocol = $this->protocol;
        $set = $this->set;
        $from = $this->from ? $this->from : '2000-01-01';
        $until = $this->until;

        if(empty($set))
            $set = $this->repository->abbreviation;
        
        if(empty($until))
            $until = Carbon::now()->format('Y-m-d');

        if(empty($protocol))
            $protocol = 'oai_dc';

        $url = $this->repository->baseURL . $verb . "&metadataPrefix=" . $protocol . "&set=" . $set . '&from=' . $from . '&until=' . $until;

        if (empty($from)) {
            $url = $this->repository->baseURL . $verb . "&metadataPrefix=" . $protocol . "&set=" . $set;
        }

        $client = new Client(array(
            'base_uri' => '',
            'verify' => false,
            'curl.options' => array(
                'CURLOPT_RETURNTRANSFER' => true,
                'CURLOPT_SSL_VERIFYPEER' =>false,
                'CURLOPT_FOLLOWLOCATION' => true,
                'CURLOPT_TCP_KEEPALIVE' => 10,
                'CURLOPT_TCP_KEEPIDLE' => 10,
                'CURLOPT_FILETIME' => true,
                'CURLOPT_TCP_NODELAY' => true,
                'CURLOPT_CONNECTTIMEOUT' => 0,
                'CURLOPT_HTTPHEADER' => true,
                'CURLOPT_FRESH_CONNECT' => true,
                'CURLOPT_USERAGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36'
            )
        ));
        $response = $client->request('GET', $url);

        if($response->getstatusCode() === 200)
        {
            $html = $response->getBody();

            $xml = new SimpleXMLElement($html);

            $this->responseDateRecord = (string)($xml->responseDate);

            if ($protocol == 'oai_dc') {
                $listRecords = $this->format_OAIDC($xml);
            } else {
                $listRecords = [];
            }

            if (count($listRecords) != 0) {
                $this->countRecord = $this->countRecord + count($listRecords);
            }
           
            if (!empty((string)$xml->ListRecords->resumptionToken) && (string)$xml->ListRecords->resumptionToken != '') {
                $listRecords = array_merge($listRecords, $this->iteratorListRecords((string)$xml->ListRecords->resumptionToken, $protocol));
            }

            $result['results'] = $listRecords;

            

        }else{
            $this->alert('error', 'Cant Harvest Repository in Your Link ', [
                'position' =>  'center', 
                'timer' =>  3000,  
                'toast' =>  true, 
                'text' =>  '', 
                'confirmButtonText' =>  'Ok', 
                'cancelButtonText' =>  'Close', 
                'showCancelButton' =>  true, 
                'showConfirmButton' =>  false, 
                'cancelButtonColor' => '#EF4444'
            ]);
        }
        $this->alert('success', $this->countRecord.' Articles Harvested Successfully', [
            'position' =>  'center', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Close', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  false, 
            'cancelButtonColor' => '#EF4444'
        ]);

        $posision = Location::get();
        History::create([
            'repoId' => $this->repository->id,
            'user_id' => Auth::user()->id,
            'from' => $from,
            'until' => $until,
            'address' => $posision->ip,
            'listRecords' => ArticleRecord::where(['repoId' => $this->repository->id])->count(),
            'countRecords' => count($result['results']),
        ]);

        $role = Auth::user()->roles->implode('name');
        if($role === 'Administrator')
        {
            return redirect()->route('admin.repositoryId', $this->repository->id);
        }else{
            return redirect()->route('assistent.repositoryId', $this->repository->id);
        }
    }

    public function iteratorListRecords($token, $protocol)
    {
        $url = $this->repository->baseURL .'/oai' ."?verb=ListRecords&resumptionToken=" . $token;

        $client = new Client(array(
            'base_uri' => '',
            'verify' => false,
            'curl.options' => array(
                'CURLOPT_RETURNTRANSFER' => true,
                'CURLOPT_SSL_VERIFYPEER' =>false,
                'CURLOPT_SSL_VERIFYHOST' =>false,
                'CURLOPT_FOLLOWLOCATION' => true,
                'CURLOPT_TCP_KEEPALIVE' => 10,
                'CURLOPT_TCP_KEEPIDLE' => 10,
                'CURLOPT_FILETIME' => true,
                'CURLOPT_TCP_NODELAY' => true,
                'CURLOPT_CONNECTTIMEOUT' => 0,
                'CURLOPT_HTTPHEADER' => true,
                'CURLOPT_FRESH_CONNECT' => true,
                'CURLOPT_USERAGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36'
            )
        ));
        $response = $client->request('GET', $url);

        if($response->getstatusCode() === 200)
        {
            $html = $response->getBody();

            $xml = new SimpleXMLElement($html);
            $this->responseDateRecord = (string)($xml->responseDate);
            if ($protocol == 'oai_dc') {
                $listRecords = $this->format_OAIDC($xml);
            } else {
                $listRecords = [];
            }

            if (count($listRecords) != 0) {
                $this->countRecord = $this->countRecord + count($listRecords);
            }
           
            if (!empty((string)$xml->ListRecords->resumptionToken) && (string)$xml->ListRecords->resumptionToken != '') {
                $listRecords = array_merge($listRecords, $this->iteratorListRecords((string)$xml->ListRecords->resumptionToken, $protocol));
            }

            $result['results'] = $listRecords;


        }else{
            $this->alert('error', 'Cant Harvest Repository in Your Link ', [
                'position' =>  'center', 
                'timer' =>  3000,  
                'toast' =>  true, 
                'text' =>  '', 
                'confirmButtonText' =>  'Ok', 
                'cancelButtonText' =>  'Close', 
                'showCancelButton' =>  true, 
                'showConfirmButton' =>  false, 
                'cancelButtonColor' => '#EF4444'
            ]);
        }

        return $result['results'];
    }
   
    public function format_OAIDC($xml)
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

                    $nodes_title = $xpath->query('//dc:title');
                    $nodes_creator = $xpath->query('//dc:creator');
                    $nodes_subject = $xpath->query('//dc:subject');
                    $nodes_description = $xpath->query('//dc:description');
                    $nodes_publisher = $xpath->query('//dc:publisher');
                    $nodes_date = $xpath->query('//dc:date');
                    $nodes_identifier = $xpath->query('//dc:identifier');
                    $nodes_source = $xpath->query('//dc:source');
                    $nodes_relation = $xpath->query('//dc:relation');

                    // Title
                    if (!empty($nodes_title) && $nodes_title->length != 0) {
                        foreach ($nodes_title as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['title'] = (string)$node->nodeValue;
                            }
                        }
                    }

                    // Description
                    if (!empty($nodes_description) && $nodes_description->length != 0) {
                        foreach ($nodes_description as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['description'] = (string)$node->nodeValue;
                            }
                        }
                    }

                    // Publisher
                    if (!empty($nodes_publisher) && $nodes_publisher->length != 0) {
                        foreach ($nodes_publisher as $node) {
                            if ($node->nodeValue != '' && !empty($node->nodeValue)) {
                                $return[$i]['publisher'] = (string)$node->nodeValue;
                            }
                        }
                    }

                    // Source
                    if(!empty($nodes_source && $nodes_source->length != 0))
                        {
                            foreach($nodes_source as $node)
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
                                    $return[$i]['issue'] = (string)($source[1]);

                                    $issue = explode(' ', (string)($source[1]));

                                    $vol = explode(',', (string)($issue[1]));

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

                        // date
                        if(!empty($nodes_date && $nodes_date->length != 0))
                        {
                            foreach($nodes_date as $node)
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

                        if(!empty($nodes_identifier && $nodes_identifier->length != 0))
                        {
                            foreach($nodes_identifier as $node)
                            {
                                // doi
                                if (substr($node->nodeValue, 0, 3) == '10.') {
                                    $return[$i]['doi'] = $node->nodeValue;
                                }
                            }
                        }

                        if (!empty($nodes_relation) && $nodes_relation->length != 0) {
                            foreach ($nodes_relation as $node) {
                                if (substr($node->nodeValue, 0, 7) == 'http://' || substr($node->nodeValue, 0, 8) == 'https://' ) {
                                    
                                    $return[$i]['file'] = str_replace('/view/', '/download/', $node->nodeValue);

                                    if(!empty($return[$i]['pages'])){
                                        $directory = storage_path('app/public/PDF/'.$this->repository->abbreviation);
            
                                        if(!File::isDirectory($directory)){
            
                                            File::makeDirectory($directory, 0777, true, true);
                                    
                                        }
                                        $filename = Str::limit(uniqid(rand()).'.pdf');
                                        $handle = fopen('storage/PDF/'.$this->repository->abbreviation.'/'.$filename, 'w');
                                        $client = new Client(array(
                                            'base_uri' => '',
                                            'verify' => false,
                                            'sink' => $handle,
                                            'curl.options' => array(
                                                'CURLOPT_RETURNTRANSFER' => true,
                                                'CURLOPT_FILE' => $handle,
                                                'CURLOPT_SSL_VERIFYPEER' =>false,
                                                'CURLOPT_SSL_VERIFYHOST' =>false,
                                                'CURLOPT_SSL_VERIFYHOST' =>false,
                                                'CURLOPT_FOLLOWLOCATION' => true,
                                                'CURLOPT_TCP_KEEPALIVE' => 10,
                                                'CURLOPT_TCP_KEEPIDLE' => 10,
                                                'CURLOPT_FILETIME' => true,
                                                'CURLOPT_TCP_NODELAY' => true,
                                                'CURLOPT_CONNECTTIMEOUT' => 0,
                                                'CURLOPT_HTTPHEADER' => true,
                                                'CURLOPT_FRESH_CONNECT' => true,
                                                'CURLOPT_USERAGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36'
                                            )
                                        ));
                                        $response = $client->get($return[$i]['file']);

                        
                                        
                                        fclose($handle);

                                        $return[$i]['file_PDF'] = 'public/PDF/';
                                    }  
                                }                       
                            }
                        }

                        // Subjects
                        $x = 0;
                        $return[$i]['subjects'] = [];
                        if(!empty($nodes_subject) && $nodes_subject->length !=0)
                        {
                            foreach($nodes_subject as $node)
                            {
                                $return[$i]['subjects'] = explode(';', $node->nodeValue);   
                            }
                        }

                        // Authors
                        $x = 0;
                        $return[$i]['authors'] = [];
                        if(!empty($nodes_creator) && $nodes_creator->length !=0)
                        {
                            foreach($nodes_creator as $node)
                            {
                                $au = explode(";", $node->nodeValue);
                                $aff = !empty($au[1]) ? $au[1] : "";
                                $name = explode(', ', (string)($au[0]));
                            
                                $return[$i]['authors'][$x]['firstname'] = (string)($name[1]);
                                $return[$i]['authors'][$x]['lastname'] = (string)($name[0]);
                                $return[$i]['authors'][$x]['affiliations'] = (string) ($aff);
                                $return[$i]['authors'][$x]['email'] = '';
                                $x++;
                            }
                        }

                        $article = ArticleRecord::updateOrCreate(['repoId' => $this->repository->id, 'identifier' => $return[$i]['identifier']],[
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

                        if($this->until === null)
                        {
                            Author::where(['article_id' => $article->id,])->delete();
                        }

                        foreach($return[$i]['authors'] as $author)
                            {
                                Author::create([
                                    'article_id' => $article->id,
                                    'firstname' => $author['firstname'],
                                    'lastname' => $author['lastname'],
                                    'affiliations' => $author['affiliations'],
                                    'email' => $author['email'],
                                ]);
                        }

                        if($this->until === null)
                        {
                            Subject::where(['article_id' => $article->id,])->delete();
                        }


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

                $i++;
            }
        }
        return $return;
    }


    public function EditArticle($id)
    {
        $article = ArticleRecord::findOrFail($id);
        $this->articleId = $id;
        $this->title = $article->title;
        $this->description = $article->description;
        $this->issue = $article->issue;
        $this->volume = $article->volume;
        $this->nomor = $article->nomor;
        $this->pages = $article->pages;
        $this->doi = $article->doi;
        $this->file_PDF = $article->file_PDF;
        $this->EditModal = true;
    }

    public function articleUpdate()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'issue' => ['required', 'string', 'max:255'],
            'volume' => ['required', 'string', 'max:255'],
            'nomor' => ['required', 'string', 'max:255'],
            'pages' => ['required', 'string', 'max:255'],
            'doi' => ['required', 'string', 'max:255'],
            'file_PDF' => ['required']
        ]);

        ArticleRecord::where(['id' => $this->articleId])->update([
            'title' => $this->title,
            'description' => $this->description,
            'issue' => $this->issue,
            'volume' => $this->volume,
            'nomor' => $this->nomor,
            'pages' =>$this->pages,
            'doi' => $this->doi,
            'file_PDF' => $this->file_PDF ? $this->file_PDF->store('public/PDF/'.$this->repository->abbreviation.'/') : null,
        ]);

        $this->EditModal = false;
        $this->resetFill();
        $this->alert('success', 'Article Updated Successfully', [
            'position' =>  'center', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Close', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  false, 
            'cancelButtonColor' => '#EF4444'
        ]);
    }

}
