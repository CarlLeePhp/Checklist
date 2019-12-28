

<div id="app">    
    <div style="height: 50px;"></div>

    <h2 class="text-center"><?php echo $title; ?></h2>

    <hr />
    <br />
    <h4 class="text-center">Dealer: <?php echo $dealer['DEALER_NAME']; ?></h4>
    <h4 class="text-center">Boat ID: <?php echo $boat['BOAT_ID']; ?></h4>
    <!-- Form -->
    <form action="<?php echo base_Url(); ?>index.php/boat/index" method="post">
        <input type="text" name="update" value="<?php echo $boat['BOAT_ID'] ?>" class="d-none"/>
  
        <div class="form-group row">
            <label for="model" class="offset-md-2 col-md-2 col-form-label text-right">Boat Model:</label>
            <div class="col-md-4"> 
                <select name="model" class="form-control">
                    <option value="<?php echo $model['MODEL_ID']; ?>"><?php echo $model['MODEL']; ?></option>
	                <?php foreach ($models as $item): ?>
			            <option value="<?php echo $item['MODEL_ID']; ?>"><?php echo $item['MODEL']; ?></option>
		            <?php endforeach; ?>
	            </select>
            </div>

        </div>
        <div class="form-group row">
            <label for="serial" class="offset-md-2 col-md-2 col-form-label text-right">Serial:</label>
            <div class="col-md-4"> 
                <input type="text" name="serial" class="form-control" value="<?php echo $boat['BOAT_SERIAL'] ?>">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </div>  
    </form>
    <!-- form end -->
</div>