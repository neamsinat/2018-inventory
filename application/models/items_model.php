

<?php
/**
 * This model contains the business logic and manages the persistence of users and roles
*/
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/**
 * This model contains the business logic and manages the persistence of users and roles
 * It is also used by the session controller for the authentication.
 */
class items_model extends CI_Model {

   
    public function showEditItems($id){
        $this->db->select('item.iditem, item.item, item.itemdescription AS "description", category.category AS "cat",category.idcategory AS "catid", condition as "condition", material.material as "mat",material.idmaterial as "matid", department.department as "depat" ,department.iddepartment as "depatid" ,location.location as "locat",location.idlocation as "locatid", users.firstname AS "nameuser",users.id AS "userid", owner.owner as "owner", owner.idowner as "ownerid" , model.model as "model", model.idmodel as "modelid" , brand.brand as "brand", brand.idbrand as "brandid" , item.itemcost AS "cost", item.date AS "date"');
        $this->db->join('category', 'category.idcategory = item.categoryid');    
        $this->db->join('material', 'material.idmaterial = item.materialid');    
        $this->db->join('department', 'department.iddepartment = item.departmentid');    
        $this->db->join('location', 'location.idlocation = item.locationid');    
        $this->db->join('users', 'users.id = item.userid');    
        $this->db->join('owner', 'owner.idowner = item.ownerid'); 
        $this->db->join('model', 'model.idmodel = item.modelid'); 
        $this->db->join('brand', 'model.brandid = brand.idbrand'); 
        $this->db->where('item.iditem', $id);
        $query = $this->db->get('item');

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    // detail item

     public function showDetailItem($id){
        $this->db->select('item.iditem, item.item, item.itemdescription AS "description", category.category AS "cat",category.idcategory AS "catid", condition as "condition", material.material as "mat",material.idmaterial as "matid", department.department as "depat" ,department.iddepartment as "depatid" ,location.location as "locat",location.idlocation as "locatid", CONCAT(skeleton_users.firstname," ",skeleton_users.lastname) AS "nameuser",users.id AS "userid", owner.owner as "owner", owner.idowner as "ownerid" , model.model as "model", model.idmodel as "modelid" , brand.brand as "brand", brand.idbrand as "brandid" , item.itemcost AS "cost", item.date AS "date", item.code, status');
        $this->db->join('category', 'category.idcategory = item.categoryid');    
        $this->db->join('material', 'material.idmaterial = item.materialid');    
        $this->db->join('department', 'department.iddepartment = item.departmentid');    
        $this->db->join('location', 'location.idlocation = item.locationid');    
        $this->db->join('users', 'users.id = item.userid');    
        $this->db->join('owner', 'owner.idowner = item.ownerid'); 
        $this->db->join('model', 'model.idmodel = item.modelid'); 
        $this->db->join('brand', 'model.brandid = brand.idbrand'); 
        $this->db->where('item.iditem', $id);
        $query = $this->db->get('item');

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function showAllItems(){
        // $query = $this->db->get('material');

        $this->db->select('CONV(skeleton_item.iditem, 10, 36) AS "itemcodeid",item.iditem, item.item, category.category AS "cat", condition as "condition", material.material as "mat", department.department as "depat" , location.location as "locat", users.firstname AS "nameuser", owner.owner as "owner",status');
        $this->db->join('category', 'category.idcategory = item.categoryid');    
        $this->db->join('material', 'material.idmaterial = item.materialid');    
        $this->db->join('department', 'department.iddepartment = item.departmentid');    
        $this->db->join('location', 'location.idlocation = item.locationid');    
        $this->db->join('users', 'users.id = item.userid');    
        $this->db->join('owner', 'owner.idowner = item.ownerid'); 
        $query = $this->db->get('item');

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
     public function deleteItems($id){
        $this->db->where('iditem', $id);
        $this->db->delete('item');
    }

    // Model select category
    public function getAllCate()
    {  
        $query = $this->db->get('category');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }

    // Model select material
    public function getAllMat()
    {  
        $query = $this->db->get('material');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }

    // Model select department
    public function getAllDep()
    {  
        $query = $this->db->get('department');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }

    // Model select location
    public function getAllLoc()
    {  
        $query = $this->db->get('location');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }

    // Model select user
    public function getAllUser()
    {  
        $query = $this->db->get('users');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }

    // Model select owner
    public function getAllOwner()
    {  
        $query = $this->db->get('owner');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }


    // Model select brand
    public function getAllBrand()
    {  
        $query = $this->db->get('brand');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }


    // Model select model
    public function getAllModel($id)
    {  
        $this->db->where('brandid', $id);
        $query = $this->db->get('model');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }

    // get item maximum id with convert

    public function getmaxiditem(){
        $this->db->select('CONV(MAX(skeleton_item.iditem),10,36) AS "IdMax"');
        $query = $this->db->get('item');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }


    // get item id with convert

    public function getiditem($id){
        $this->db->select('CONV(skeleton_item.iditem,10,36) AS "IdMax"');
        $this->db->where('item.iditem',$id);
        $query = $this->db->get('item');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }


    // get location by id

    public function getLocById($id)
    {  
        $this->db->where('idlocation',$id);
        $query = $this->db->get('location');  
        if($query->num_rows() > 0)
        {   
            return $query->result();  
        }else{   
            return false;  
        } 
    }


    //     // Insert item to database 
    public function add_item($nameitem,$desitem,$catitem,$matitem,$depitem,$locitem,$moditem,$useritem,$ownitem,$conditionitem,$dateitem,$costitem,$code)
    {
        
        $data = array(
            'item'=> $nameitem,
            'itemdescription'=> $desitem,
            'categoryid'=> $catitem,
            'materialid'=> $matitem,
            'departmentid'=> $depitem,
            'locationid'=> $locitem,
            'modelid'=> $moditem,
            'userid'=> $useritem,
            'ownerid'=> $ownitem,
            'condition'=> $conditionitem,
            'date'=> $dateitem,
            'itemcost'=> $costitem,
            'status'=> '0',
            'code'=> $code
        );

        return $query=$this->db->insert('item',$data);
    }
       // update item to database 
    public function update_item($nameitem,$desitem,$catitem,$matitem,$depitem,$locitem,$moditem,$useritem,$ownitem,$conditionitem,$dateitem,$costitem,$code,$id)
    {
        
        $data = array(
            'item'=> $nameitem,
            'itemdescription'=> $desitem,
            'categoryid'=> $catitem,
            'materialid'=> $matitem,
            'departmentid'=> $depitem,
            'locationid'=> $locitem,
            'modelid'=> $moditem,
            'userid'=> $useritem,
            'ownerid'=> $ownitem,
            'condition'=> $conditionitem,
            'date'=> $dateitem,
            'itemcost'=> $costitem,
            'status'=> '0',
            'code'=> $code
        );
        $this->db->where('item.iditem',$id);
        $this->db->set($data);
        return $this->db->update('item');
    }

}
