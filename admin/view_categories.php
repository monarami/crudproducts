<?php
session_start();
include_once("../database/db_conection.php");
if(!$_SESSION['admin_user'])  
{  
  header("Location: index.php"); 
}  
include_once("../header.php");
?>
<body>
<?php
$error_flag = false;
$cat_name = $parent_id = ""; 
if(isset($_POST['addcategory'])){
    $cat_name=mysqli_real_escape_string($db_conn,$_POST['categoryname']);//here getting result from the post array after submitting the form. 
    $cat_pid =mysqli_real_escape_string($db_conn,$_POST['selectcategory']);//same
    
    //here query check weather if user already registered so can't register again.   
    $check_category_query="select * from category WHERE cat_name='$cat_name' AND parent_id='$cat_pid'"; 
    
    $result = mysqli_query($db_conn, $check_category_query);   
    if(mysqli_num_rows($result)>0){
        $error_flag = true;
        echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'>Category <strong>$cat_name</strong> is already exist in our database, Please try another one!</div>";      
    }
    
    //insert the category into the database.
    if ($error_flag == false) {
    
    $insert_category="insert into category (cat_name,parent_id) VALUE ('$cat_name','$cat_pid')";
    if(mysqli_query($db_conn,$insert_category))  
    {
        $last_id = mysqli_insert_id($db_conn);
        //Recursive php function
        function tree_path($last_id){
        global $db_conn;
        global $path;
        
        $select_tree_query="Select parent_id from category where id ='".$last_id."'";
        $tree =mysqli_query($db_conn,$select_tree_query);
        
        while($treerow = mysqli_fetch_object($tree)){
             if ($treerow->parent_id != 0){
                tree_path($treerow->parent_id);
                $path = $path.'/'.$treerow->parent_id;  
             }   
        }
        return $path.'/'.$last_id;
        }
        $sql_tree_path = tree_path($last_id);
        $sql_trim_path = trim($sql_tree_path,"/");
       
        $update_tree_path_qry ="UPDATE category SET tree_path='$sql_trim_path' where id='$last_id'";
        
        if(mysqli_query($db_conn,$update_tree_path_qry)) {
            //new code for category name start
        $select_catid_query="Select tree_path from category where id ='".$last_id."'";
        $tree_name =mysqli_query($db_conn,$select_catid_query);
        
        $final_tree_name=mysqli_fetch_row($tree_name); 
        $final_tree_name = str_replace('/', ',', $final_tree_name);
        
       
        if (!empty($final_tree_name[0])){
            
            $select_catid_tree_name_query="Select GROUP_CONCAT(cat_name) FROM category where id IN ($final_tree_name[0])";
            
            $tree_dash_name =mysqli_query($db_conn,$select_catid_tree_name_query);
            $final_tree_dash_name =mysqli_fetch_row($tree_dash_name);
            $query_tree_name = str_replace(',', '>>', $final_tree_dash_name);          
        }
        if (!empty($query_tree_name)){
            $update_tree_name_qry ="UPDATE category SET tree_name='$query_tree_name[0]' where id='$last_id'";
        }

        //new code for category name start
            
        }

        if(mysqli_query($db_conn,$update_tree_name_qry)) {
            echo "<div role='alert' class='alert alert-success alert-dismissible fade in'>Category <strong>$cat_name </strong> has been added successfully.</div>"; 
        }
        
    } 
    } 
    
}
?>
<div class="container">
<div class="row">
    <!--<div class="col-md-4 col-md-offset-4">-->
    <div class="login-panel panel panel-success">
    <div class="panel-heading">  
        <h3 class="panel-title text-center">Add Category</h3>  
    </div> 
    <div class="panel-body">   
    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <fieldset> 
    
    <div class="form-group">
        <label for="exampleInputgender">Select Category:</label>
        
        <?php
        function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = '') {
          global $db_conn;
          if (!is_array($user_tree_array))
            $user_tree_array = array();
          $select_categorydropdown_query="Select * from category where 1 AND parent_id ='".$parent."' ORDER BY id ASC";
         
          $query = mysqli_query($db_conn,$select_categorydropdown_query);
          if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_object($query)) {
            $user_tree_array[] = array("id" => $row->id, "name" => $spacing . $row->cat_name);
            $user_tree_array = fetchCategoryTree($row->id, $spacing . '&nbsp;&nbsp;', $user_tree_array);
            }
          }
          return $user_tree_array;
        }
    ?>
    <?php 
        $categoryList = fetchCategoryTree(); 
    ?>
    <select class="form-control" name='selectcategory' required>            
            <option value=''>None</option>
            <option value='0'>Parent Category</option>
            <?php foreach($categoryList as $cl) { ?>
                <option value="<?php echo $cl["id"]; ?>"><?php echo $cl["name"]; ?></option>
            <?php } ?>

    </select>
    </div>
    <?php
        category_tree(0);
        
        //Recursive php function
        function category_tree($catid){
        global $db_conn;
        
        $select_category_query="Select * from category where parent_id ='".$catid."'";
        $result =mysqli_query($db_conn,$select_category_query);
        
        while($row = mysqli_fetch_object($result)){
            $i = 0;
            if ($i == 0) echo '<ul>';
              echo '<li id="'.$row->id.'">' . $row->cat_name;
             category_tree($row->id);
             echo '</li>';
            $i++;
             if ($i > 0) echo '</ul>';
        }
        }
    ?>
    <div class="form-group">
        <label for="exampleInputcategory">Category Name</label>
        <input type="text" placeholder="Category name" name="categoryname" value="" class="form-control" required autofocus> 
    </div>
    <input class="btn btn-lg btn-success btn-block" type="submit" value="Add Category" name="addcategory" >  
  
   </fieldset>  
    
    </form>
    </div>
    </div>
    <!--</div>-->
</div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="lib/js/bootstrap.min.js"></script>
    
  </body>
</html>