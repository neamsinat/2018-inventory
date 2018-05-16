<?php
/**
 * This controller serves the user management pages and tools.
 * @copyright  Copyright (c) 2014-2017 Benjamin BALET
 * @license    http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link       https://github.com/bbalet/skeleton
 * @since      0.1.0
 */

if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This controller serves the user management pages and tools.
 * The difference with HR Controller is that operations are technical (CRUD, etc.).
 */
class items extends CI_Controller {
    public function __construct() {
        parent::__construct();
        log_message('debug', 'URI=' . $this->uri->uri_string());
        $this->session->set_userdata('last_page', $this->uri->uri_string());
        if($this->session->loggedIn === TRUE) {
           // Allowed methods
           if ($this->session->isAdmin || $this->session->isSuperAdmin) {
             //User management is reserved to admins and super admins
           } else {
             redirect('errors/privileges');
         }
     } else {
       redirect('connection/login');
   }
   $this->load->model('items_model');
}

    /**
     * Display the list of all users
     * @author Benjamin BALET <benjamin.balet@gmail.com>
     */
    public function index() {
        $this->load->helper('form');
        $data['title'] = 'List of Items';
        $data['activeLink'] = 'items';
        $data['flashPartialView'] = $this->load->view('templates/flash', $data, TRUE);
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('items/index', $data);
        $this->load->view('templates/footer', $data);
    }



// list items
    public function showAllitems(){
        $result = $this->items_model->showAllItems();
        echo json_encode($result);
    }
// delete item
    public function deleteItems(){
        $iditem=  $this->input->post('iditem');
        $remove_item = $this->items_model->deleteItems($iditem);
        if ($remove_item) {
            echo "1";
        }else{
            echo "0";
        }
    }
    
    // show form edit item
    public function edit() { 
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Update item';
        $data['activeLink'] = 'items';
        $id = $this->uri->segment(3);
        $data['itemEdit']=$this->items_model->showEditItems($id);
        // var_dump($data['itemEdit']);die();
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('items/edit', $data);
        $this->load->view('templates/footer');
    }
    
// update data item
    public function itemUpdate(){
        $id = $this->uri->segment(3);
        $nameitem = $this->input->post('nameitem');
        $desitem = $this->input->post('desitem');
        $catitem = $this->input->post('catitem');
        $matitem = $this->input->post('matitem');
        $depitem = $this->input->post('depitem');
        $locitem = $this->input->post('locitem');
        $moditem = $this->input->post('moditem');
        $useritem = $this->input->post('useritem');
        $ownitem = $this->input->post('ownitem');
        $conditionitem = $this->input->post('conditionitem');
        $dateitem = $this->input->post('dateitem');
        $costitem = $this->input->post('costitem');

        $getIdMax = $this->items_model->getiditem($id);
        foreach ($getIdMax as $value) {
            $idmaximum = $value->IdMax;
        }

        // echo $idmaximum;
        $getLoc = $this->items_model->getLocById($locitem);
        foreach ($getLoc as $value) {
            $locnamebyid = $value->location;
        }
        $code = $locnamebyid.'-'.$idmaximum;

        $item_update = $this->items_model->update_item($nameitem,$desitem,$catitem,$matitem,$depitem,$locitem,$moditem,$useritem,$ownitem,$conditionitem,$dateitem,$costitem,$code,$id);
        if ($item_update) {
            redirect('items');
        }
        
    }

// show form create item
    public function create() { 
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Create a new Item';
        $data['activeLink'] = 'items';
        $this->load->view('templates/header', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('items/create', $data);
        $this->load->view('templates/footer');
    }

// add data create item
    public function itemcreate(){
        $nameitem = $this->input->post('nameitem');
        $desitem = $this->input->post('desitem');
        $catitem = $this->input->post('catitem');
        $matitem = $this->input->post('matitem');
        $depitem = $this->input->post('depitem');
        $locitem = $this->input->post('locitem');
        $moditem = $this->input->post('moditem');
        $useritem = $this->input->post('useritem');
        $ownitem = $this->input->post('ownitem');
        $conditionitem = $this->input->post('conditionitem');
        $dateitem = $this->input->post('dateitem');
        $costitem = $this->input->post('costitem');

        $getIdMax = $this->items_model->getmaxiditem();
        foreach ($getIdMax as $value) {
            $idmaximum = $value->IdMax;
        }

        if ($catitem=='' || $matitem=='' || $depitem=='' || $locitem=='' || $moditem=='' || $useritem==''|| $ownitem=='') {
            redirect('items/create');
        }else{
            $getLoc = $this->items_model->getLocById($locitem);
            foreach ($getLoc as $value) {
                $locnamebyid = $value->location;
            }
            $code = $locnamebyid.'-'.$idmaximum;

            $item_insert = $this->items_model->add_item($nameitem,$desitem,$catitem,$matitem,$depitem,$locitem,$moditem,$useritem,$ownitem,$conditionitem,$dateitem,$costitem,$code);
            if ($item_insert) {
                redirect('items');
            }
        }
    }

// cat list
    public function showAllCategories()
    {       
        $result = $this->items_model->getAllCate();   
        echo json_encode($result);    
    }
// mat list
    public function showAllMaterials()
    {       
        $result = $this->items_model->getAllMat();   
        echo json_encode($result);    
    }
// dep list
    public function showAllDepartments()
    {       
        $result = $this->items_model->getAllDep();   
        echo json_encode($result);    
    }

// loc list
    public function showAllLocations()
    {       
        $result = $this->items_model->getAllLoc();   
        echo json_encode($result);    
    }

// user list
    public function showAllUsers()
    {       
        $result = $this->items_model->getAllUser();   
        echo json_encode($result);    
    }

// owner list
    public function showAllOwners()
    {       
        $result = $this->items_model->getAllOwner();   
        echo json_encode($result);    
    }

// brand list
    public function showAllBrands()
    {       
        $result = $this->items_model->getAllBrand();   
        echo json_encode($result);    
    }

    // brand list
    public function showAllModelsByBrand()
    {   
        $brandid = $this->uri->segment(3);
        $result = $this->items_model->getAllModel($brandid);   
        echo json_encode($result);    
    }

    // detail item

    public function showDetailItem(){
     $form = '';
     $iditem=  $this->input->post('iditem'); 
     $result = $this->items_model->showDetailItem($iditem);
     $status='';
     if ($result>0) {
        foreach ($result as $value) {
            if ($value->status==0) {
               $status='Available';
            }else{
                $status='Not available';
            }
        $form .='<tr>';
        $form .='<td>Name </td>';
        $form .='<td>: '.$value->item.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Description </td>';
        $form .='<td>: '.$value->description.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Label </td>';
        $form .='<td>: '.$value->code.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Cost of item </td>';
        $form .='<td>: $'.$value->cost.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Condition </td>';
        $form .='<td>: '.$value->condition.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Type </td>';
        $form .='<td>: '.$value->cat.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<tr>';
        $form .='<td>Brand </td>';
        $form .='<td>: '.$value->brand.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Model </td>';
        $form .='<td>: '.$value->model.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Material </td>';
        $form .='<td>: '.$value->mat.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Location </td>';
        $form .='<td>: '.$value->locat.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Department </td>';
        $form .='<td>: '.$value->depat.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Username </td>';
        $form .='<td>: '.$value->nameuser.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Owner </td>';
        $form .='<td>: '.$value->owner.'</td>';
        $form .='</tr>';
        $form .='<tr>';
        $form .='<td>Status </td>';
        $form .='<td>: '.$status.'</td>';
        $form .='</tr>';
    }
}
echo json_encode($form);
}
}