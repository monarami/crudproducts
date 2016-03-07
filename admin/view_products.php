<?php
session_start();
include_once("../database/db_conection.php");
if(!$_SESSION['admin_user'])  
{  
  header("Location: index.php"); 
}  
include_once("../header.php");
if(isset($_SESSION['update_product_success'])){
    echo $_SESSION['update_product_success'];
    unset ($_SESSION['update_product_success']);
}
if(isset($_SESSION['add_product_success'])){
    echo $_SESSION['add_product_success'];
    unset ($_SESSION['add_product_success']);
}
if(isset($_SESSION['update_product_statuserror'])){
    echo $_SESSION['update_product_statuserror'];
    unset ($_SESSION['update_product_statuserror']);
}
if(isset($_SESSION['update_product_skuerror'])){
    echo $_SESSION['update_product_skuerror'];
    unset ($_SESSION['update_product_skuerror']);
}
if(isset($_SESSION['update_product_imageerror'])){
    echo $_SESSION['update_product_imageerror'];
    unset ($_SESSION['update_product_imageerror']);
}
?>
<body>
<div class="container">
	<div class="row">
	<div class="table-scrol"> 
		<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
	    		<h1 align="center">All the Products</h1> 
	    </div>  
	    </div>
	    <p></p>
	    <div class="row">
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
        	<form action='add_products.php' method="post">      				
			<input type="submit" class="btn btn-success" name="addproducts" value="Add Products">
			</form>
        </div> <!--btn btn-danger is a bootstrap button to show danger-->
		<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
        <a href="view_categories.php" class="btn btn-success" role="button">Categories</a>
        </div>	
		<div class="pull-right offset-0">		
		<!-- Small log out modal start -->
		<button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-sign-out"></i>Logout</button>

		<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
			  <div class="modal-header"><h4>Logout <i class="fa fa-lock"></i></h4></div>
			  <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
			  <div class="modal-footer"><a href="logout.php?logout" class="btn btn-danger btn-block">Logout</a></div>
			</div>
		  </div>
		</div>
		<!-- Small log out modal ends -->
		</div>
		</div>
		<p></p>
		
		<div class="row">
		<div class="table-responsive"><!--this is used for responsive display in mobile and other devices-->  
	  
	  
	    <table id="example" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
	        <thead>
	        <tr>  
                <th style="width: 2%;">Id</th> 
                <th class="col-md-1 col-sm-1">Product SKU</th>  
	            <th class="col-md-1 col-sm-1">Product Name</th>
	            <th class="col-md-1 col-sm-1">Product Status</th>  
	            <th style="width: 6%;">Product Start Date</th> 
	            <th style="width: 6%;">Product End Date</th> 
	            <th class="col-md-1 col-sm-1">Product Description</th>   
	            <th class="col-md-1 col-sm-1">Product Image</th>
	            <th class="col-md-1 col-sm-1">Product Category</th>    
	            <th class="col-md-1 col-sm-1">Category Tree</th> 
	            <th class="col-md-1 col-sm-1">Action</th> 
            </tr>  
	        </thead> 
	        <tfoot>
            <tr>  
                <th style="width: 2%;">Id</th> 
                <th class="col-md-1 col-sm-1">Product SKU</th>  
                <th class="col-md-1 col-sm-1">Product Name</th>
                <th class="col-md-1 col-sm-1">Product Status</th>  
                <th style="width: 6%;">Product Start Date</th> 
	            <th style="width: 6%;">Product End Date</th> 
                <th class="col-md-1 col-sm-1">Product Description</th>   
                <th class="col-md-1 col-sm-1">Product Image</th>
                <th class="col-md-1 col-sm-1">Product Category</th>    
                <th class="col-md-1 col-sm-1">Category Tree</th> 
                <th class="col-md-1 col-sm-1">Action</th>	             
            </tr>  
            </tfoot>  
	        <tbody>
	        <?php  
	        $num_rec_per_page=10;
	        if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
	        $start_from = ($page-1) * $num_rec_per_page; 
	        $view_product_query="select * from product LIMIT $start_from, $num_rec_per_page";//select query for viewing users. 
	        $run=mysqli_query($db_conn,$view_product_query);//here run the sql query.  
	  		if(mysqli_num_rows($run)>0){
	        while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.  
	        {  
	            $product_id=$row[0];  
	            $product_sku=$row[1];
                $product_name=$row[2];   
	            $product_status=$row[3];
	            $product_start_date=$row[4];  
	            $product_end_date=$row[5]; 
                $product_des=$row[6];   
                $product_image=$row[7];  
                $product_category=$row[8]; 
	             
                $view_product_category="Select GROUP_CONCAT(cat_name),GROUP_CONCAT(tree_name) FROM category where id IN ($product_category)";//select query for viewing Products.  
                
                $pro_cat_run = mysqli_query($db_conn,$view_product_category);//here run the sql query.  

                $pro_cat_row=mysqli_fetch_row($pro_cat_run);//while look to fetch the result and store in a array $row.  
                $category_name = $pro_cat_row[0];
                $category_name = str_replace(',', '<br>', $category_name); 
                $tree_name = $pro_cat_row[1];
                $tree_name = str_replace(',', '<br>', $tree_name); 
            ?>  
	  
	        <tr>  
	            <!--here showing results in the table -->  
	            <td style="width: 2%;"><?php echo $product_id;  ?></td>  
	            <td class="col-md-1 col-sm-1"><?php echo $product_sku;  ?></td>
	            <td class="col-md-1 col-sm-1"><?php echo $product_name;  ?></td> 
	            <td class="col-md-1 col-sm-1"><?php echo ($product_status == 1)?'Active':'Inactive';  ?></td>  
	            <td style="width: 6%;"><?php echo $product_start_date;  ?></td>
	            <td style="width: 6%;"><?php echo $product_end_date;  ?></td>    
	            <td class="col-md-2 col-sm-2"><?php echo $product_des;  ?></td>
	            
	            <td class="col-md-1 col-sm-1"><img alt="<?php echo $product_name;?>" height="100px" width="100px" src="../productuploads/<?php echo $product_image;?>"></td>  
	            <td class="col-md-1 col-sm-1">
                    <?php echo $category_name;  ?>
                </td>  
                <td class="col-md-1 col-sm-1">
                    <?php echo $tree_name;  ?>
                </td>  
                
	            <td class="col-md-1">	            	
	            	<form action='edit_products.php' method="post">
      				<input type="hidden" name="editproductid" value="<?php echo $product_id ?>">
      				<input type="submit" class="btn btn-success" name="editproduct" value="Edit">
      				</form>
      				<p></p>
      				<input type="submit" class="btn btn-danger delete" id="<?php echo $product_id; ?>" name="deleteproduct" value="Delete">
      				
      				
	            </td> <!--btn btn-danger is a bootstrap button to show danger-->	             
	            
	            
	        </tr>  
	  
	        <?php }
	        } else {
				echo "<tr><td colspan='11'><h3 class='text-center'>No Products Found</h3></tr></td>";
			}
	        
	        ?>  
	        </tbody>
	    </table> 
	    <?php 
		$paginationsql = "SELECT * FROM product"; 
		$pagination_result = mysqli_query($db_conn,$paginationsql); //run the query
		$total_records = mysqli_num_rows($pagination_result);  //count number of records
		$total_pages = ceil($total_records / $num_rec_per_page); 
		
		echo "<a href='view_products.php?page=1'>".'|<'."</a> "; // Goto 1st page  

		for ($i=1; $i<=$total_pages; $i++) { 
		    echo "<a href='view_products.php?page=".$i."'>".$i."</a> "; 
		}; 
		echo "<a href='view_products.php?page=$total_pages'>".'>|'."</a> "; // Goto last page
		?> 
	    </div>  
	    </div>
	</div>
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="lib/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
	$(function() {
	$(".btn.btn-danger.delete").click(function(){
	var element = $(this);
	var del_id = element.attr("id");
	var info = 'id=' + del_id;
	if(confirm("Are you sure you want to delete this?"))
	{
	 $.ajax({
	   type: "POST",
	   url: "delete_products.php",
	   data: info,
	   success: function(){
	   	
	 }
	});
      //$(this).parents("tr").animate({backgroundColor: "#003" }, "slow").animate({opacity: "hide"}, "slow").remove();
     // $(this).parents("tr").remove(); 
       	$( this ).parents("tr").hide( 1200, function() {
    	$( this ).remove();
  		});
	 }
	return false;
	});
	});
</script>
     
  </body>
</html>