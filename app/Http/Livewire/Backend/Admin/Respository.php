<?php

namespace App\Http\Livewire\Backend\Admin;

use App\Models\Repository;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use SimpleXMLElement;

class Respository extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $repository = false;
    public $repositoryUP = false;
    public $paginate= 10;
    public $sortBy = 'id';
    public $search = '';
    public $sortDirection = 'asc';
    public $baseURL;
    public $repoId;
    public $repoTitle;
    public $repoDescription;
    public $repoThumnail;
    public $abbreviation;
    public $adminEmail;
    public $printISSN;
    public $onlineISSN;

    public function render()
    {
        $repositories = Repository::query()->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.backend.admin.respository', compact('repositories'))
        ->extends('layouts.Be')
        ->section('content');
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

    private function ResetFill()
    {
        $this->baseURL = '';
        $this->repoTitle = '';
        $this->repoDescription = '';
        $this->repoThumnail = '';
        $this->abbreviation = '';
        $this->adminEmail = '';
        $this->printISSN = '';
        $this->onlineISSN = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function newRepository()
    {
        $this->ResetFill();
        $this->repository = true;
    }

    private $results = array();

    public function storeRepository()
    {                     
       $url = $this->baseURL;

       $client = new Client([$url]);

       $response = $client->request('GET', $url);

       if($response->getstatusCode() === 200)
       {
           $html = $response->getBody();

           $dom = new DOMDocument();

           @$dom->loadHTML($html);
           
           $xpath = new DOMXPath($dom);
           
           $repoTitle = $xpath->query('//*[@id="main"]/h2');
           $repoDescription = $xpath->query('//*[@id="journalDescription"]/p[1]');
           $repoThumnail = $xpath->query('//*[@id="homepageImage"]/img/@src');
           $repoISSN = $xpath->query('//*[@id="pageFooter"]/p[1]/text()');
           

            // RepoTitle
            if(!empty($repoTitle->length !== 0))
            {
                foreach($repoTitle as $node)
                {
                    $this->repoTitle = (string)($node->nodeValue);
                }

                foreach($repoDescription as $node)
                {
                    $this->repoDescription = (string)($node->nodeValue);
                }

                foreach($repoThumnail as $node)
                {
                    if(!empty($repoThumnail))
                    {
                        $this->repoThumnail =  (string)($node->nodeValue);
                    }else{
                        $this->repoThumnail = '';
                    }
                    
                }

                foreach($repoISSN as $node)
                {
                    $source = explode(', ', $node->nodeValue);
                    
                    $printISSN = explode(' ', $source[0]);

                    if(!empty($source[1]))
                    {
                        $onlineISSN = explode(' ', $source[1]);
                    }else{
                        $onlineISSN = '';
                    }

                    $this->printISSN = (string)($printISSN[1]);

                    if(!empty($onlineISSN[1]))
                    {
                        $this->onlineISSN = (string)($onlineISSN[1]);
                    }else{
                        $this->onlineISSN = '';
                    }
                }

                $this->validate([
                    'baseURL' => ['required', 'unique:repositories,baseURL,'.$this->repoId]
                ]);
                Repository::updateOrCreate(['id' => $this->repoId], [
                    'repoTitle' => $this->repoTitle,
                    'repoDescription' => $this->repoDescription,
                    'baseURL' => $this->baseURL,
                    'repoThumnail' => $this->repoThumnail,
                    'abbreviation' => $this->abbreviation,
                    'adminEmail' => $this->adminEmail,
                    'printISSN' => $this->printISSN,
                    'onlineISSN' => $this->onlineISSN,
                ]);

                $this->alert('success', 'Repository Harvested Successfully', [
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
       }

        $this->ResetFill();
        $this->repository = false;
    }

    public function deleteRepository($id)
    {
        Repository::findOrFail($id)->delete();

        $this->alert('success', 'Repository Deleted Successfully', [
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

    public function editRepo($id)
    {
        $repo = Repository::findOrFail($id);
        $this->repoId = $id;
        $this->repoTitle = $repo->repoTitle;
        $this->repoDescription = $repo->repoDescription;
        $this->baseURL = $repo->baseURL;
        $this->repoThumnail = $repo->repoThumnail ?  $repo->repoThumnail : '';
        $this->abbreviation = $repo->abbreviation;
        $this->adminEmail = $repo->adminEmail;
        $this->printISSN = $repo->printISSN;       
        $this->onlineISSN = $repo->onlineISSN;

        $this->repositoryUP = true;
    }

    public function updateRepo()
    {
        $this->validate([
            'repoTitle' => ['required', 'string', 'max:255'],
            'repoDescription' => ['required'],
            'baseURL' => ['required', 'unique:repositories,baseURL,'.$this->repoId],
            'repoThumnail' => ['nullable'],
            'abbreviation' => ['nullable', 'string', 'max:255'],
            'adminEmail' => ['nullable', 'string', 'max:255'],
            'printISSN' => ['required', 'string', 'max:255'],
            'onlineISSN' => ['required', 'string', 'max:255'],
        ]);

        Repository::where(['id' => $this->repoId])->update([
            'repoTitle' => $this->repoTitle,
            'repoDescription' => $this->repoDescription,
            'baseURL' => $this->baseURL,
            'repoThumnail' => $this->repoThumnail ? $this->repoThumnail->store('public/thumnail') : '',
            'abbreviation' => $this->abbreviation,
            'adminEmail' => $this->adminEmail,
            'printISSN' => $this->printISSN,
            'onlineISSN' => $this->onlineISSN,
        ]);

        $this->alert('success', 'Repository Harvested Successfully', [
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

        $this->ResetFill();
        $this->repositoryUP = false;
    }

    public function synkRepo($id)
    {
        $repo = Repository::findOrFail($id);
        $url = $repo->baseURL;

        $client = new Client();
        $response = $client->request('GET', $url.'/oai?verb=Identify');

        if($response->getStatusCode() === 200)
        {
            $html = $response->getBody();
            $dom = new SimpleXMLElement($html);

           Repository::where(['id' => $id])->update([
                'repoTitle' => (string)($dom->Identify->repositoryName),
                'adminEmail' => (string)($dom->Identify->adminEmail),
            ]);
            
            $this->alert('success', 'Repository Synced Successfully', [
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
}
