

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<br />

    <form action="<?php echo base_Url(); ?>index.php/dealer/index" method="post">
        <input type="text" name="remove" value="<?php echo $dealer['DEALER_ID'] ?>" class="d-none"/>
        <div class="form-group row">
            <label for="dealer" class="offset-md-2 col-md-2 col-form-label text-right">Dealer:</label>
            <div class="col-md-4"> 
                <input type="text" name="dealer" class="form-control" value="<?php echo $dealer['DEALER_NAME'] ?>">
            </div>
            
        </div>    
        <div class="form-group row">
            <label for="sale" class="offset-md-2 col-md-2 col-form-label text-right">Sale:</label>
            <div class="col-md-4"> 
                <select name="sale" class="form-control">
                    <option value="<?php echo $dealer['SALE_ID']; ?>"><?php echo $dealer['SALE_NAME']; ?></option>
	                <?php foreach ($sales as $sale): ?>
			            <option value="<?php echo $sale['SALE_ID']; ?>"><?php echo $sale['SALE_NAME']; ?></option>
		            <?php endforeach; ?>
	            </select>
            </div>
            <button type="submit" class="btn btn-danger">Confirm</button>
        </div>
    </form>
    <!-- form end -->
    
</div> <!-- App -->