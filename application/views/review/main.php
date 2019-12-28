<style>
    tr.OPT{
        background-color: #c9c9c9;
    }
</style>

<div id="app">    
<div style="height: 50px;"></div>

<h2 class="text-center"><?php echo $title; ?></h2>

<hr />
<h4 class="text-center">{{ messages }}</h4>
<br />

    <form action="" v-on:submit.prevent="onSubmit">
        <div class="form-goup row">
            <label for="Dealer" class="offset-md-2 col-md-2 col-form-label text-right">Dealer:</label>
            <div class="col-md-4"> 
                <select name="Dealer" id="Dealer" class="form-control" v-model="dealer" @change="dealerHandler">
                    <option value="0">Please choose a Dealer</option>
                    <option v-for="dealer in dealers" :key="dealer.id" :value="dealer.id">{{ dealer.des }}</option>
                </select>
                
            </div>
        </div>

        <br />
        <div class="form-group row">
            <label for="serial" class="offset-md-2 col-md-2 col-form-label text-right">Boat Model:</label>
            <div class="col-md-4"> 
                <select name="serial" class="form-control" v-model="model" @change="modelHandler">
                    <option v-for="model in models" :value="model">{{ model }}</option>
	            </select>
            </div>
            
        </div>

        <div class="form-group row">
            <label for="serial" class="offset-md-2 col-md-2 col-form-label text-right">Serial:</label>
            <div class="col-md-4"> 
                <select name="serial" class="form-control" v-model="boat" @change="boatHandler">
                    <option v-for="boat in selectedBoats" :key="boat.BOAT_ID" :value="boat.BOAT_ID">{{ boat.BOAT_SERIAL }}</option>
	            </select>
            </div>
            
        </div>

        <div class="form-group row">
            <label for="transporter" class="offset-md-2 col-md-2 col-form-label text-right">Transporter:</label>
            <div class="col-md-4"> 
                <input type="text" name="transporter" class="form-control" :value="transporter" disabled>
            </div>
            
        </div>

        <div class="form-group row">
            <label for="chdate" class="offset-md-2 col-md-2 col-form-label text-right">Last Updated:</label>
            <div class="col-md-4"> 
                <input type="text" name="chdate" class="form-control" :value="chdate" disabled>
            </div>
            
        </div>
        <br />
    </form>
    <!-- form end -->

    <!-- Check List Table -->
    <div class="row">
        <table class="table offset-md-2 col-md-8">
            <thead>
                <tr>
                    <th scop="col">ID</th>
                    <th scop="col">Description</th>
                    <th scop="col">Checked</th>
                </tr> 
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.CL_ID" :class="item.TYPE">
                    <td>{{ item.CL_ID }}</td>
                    <td>{{ item.CL_DES }}</td>
                    <td><input type="checkbox" v-model="item.CHECKED" disabled></td>
                </tr>
                
            </tbody>
        </table>
    </div>
    <br />
    <!-- Check List Table End -->

    <!-- Missed Parts -->
    <div class="form-row">
        <div class="form-goup offset-md-2 col-md-8">
            <label for="missed">Missing Items</label>
            <textarea name="missed" class="form-control" row="5" v-model="missed" disabled> </textarea>
        </div>
    </div>
    <br />
    <!-- Missed Parts End -->

    <!-- Additional Items -->
    <div class="form-row">
        <div class="form-goup offset-md-2 col-md-8">
            <label for="additional">Additional Items</label>
            <textarea name="additional" class="form-control" row="5" v-model="additional" disabled> </textarea>
        </div>
    </div>
    <br />
    <!-- Additional Items End -->

    <h4 class="text-center">Pictures</h4>
    <hr />
    <div class="d-flex align-content-start flex-wrap">
        <div class="col-md-4 mb-2" v-for="item in picture_srcs" :key="item.id">
            <img :src="item.src" class="img-fluid" />
            <a :href="item.src" target="_blank" rel="noopener noreferrer">Open</a>
        </div>
        
    </div>
    <br />


</div> <!-- App -->

<!-- Vue -->
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script src="<?php echo base_Url(); ?>lib/html2canvas.js"></script>

<script>

    var app = new Vue({
        el: '#app',
        data: {
            messages: "<?php echo $message; ?>",
            dealer: "0",
            dealers: [
                <?php foreach ($dealers as $dealer): ?>
                    {id: "<?php echo $dealer['DEALER_ID'] ?>", des: "<?php echo $dealer['DEALER_NAME'] ?>"},
                <?php endforeach; ?>
            ],
            boats: [
                {BOAT_ID: "",  BOAT_SERIAL: "", MODEL: "", TP_NAME: ""}
                ],
            selectedBoats: [
                {BOAT_ID: "",  BOAT_SERIAL: "", MODEL: "", TP_NAME: ""}
                ],
            boat: "", // boat id
            model: "",
            models: [],
            serial: "",
            transporter: "", // string
            items: [{CL_ID: 0, BOAT_ID: 0, CL_DES: "", CHECKED: 0, TYPE: ""}],
            userfiles: [], // Upload pictures, Array
            picture_srcs: [
                {id: 0, src: "", name: ""}
            ],
            more_picture_srcs: [
                {id: 0, src: ""}
            ],
            missed: "", // missed parts
            additional: "",
            chdate: "",
        },
        methods: {
            dealerHandler: function (){

                var formData = new FormData()
                formData.append('dealer_id', this.dealer)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_boats/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.boats = []
                    this.models = []
                    this.selectedBoats = []
                    for (var i=0; i<result.length; i++){
                        this.boats.push(result[i])
                        this.selectedBoats.push(result[i])
                        if(! this.models.includes(result[i].MODEL)){
                            this.models.push(result[i].MODEL)
                        }
                        
                    }
                    this.sortBoatBySerial()
                    
                }, res => {
                    // error callback
                    this.messages = "POST FAIL"
                })

                
            },
            modelHandler: function(){
                this.selectedBoats = []
                for(var i=0; i<this.boats.length; i++){
                    if(this.model == this.boats[i].MODEL){
                        this.selectedBoats.push(this.boats[i])
                    }
                }
                this.sortBoatBySerial()
            },
            sortBoatBySerial: function(){
                this.selectedBoats.sort(function(a, b){return a.BOAT_SERIAL - b.BOAT_SERIAL})
            },
            boatHandler: function(){ // there is a copy of this method called mounted, anything changed here should be changed there too
                // set the transporter and serial
                for(var i=0; i<this.boats.length; i++){
                    if(this.boat == this.boats[i].BOAT_ID){
                        this.transporter = this.boats[i].TP_NAME
                        this.serial = this.boats[i].BOAT_SERIAL
                    }
                }

                // get check list
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_checklist/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.items = []
                    for(var i=0;i<result.length;i++){
                        if(result[i].CHECKED == "0") {
                            result[i].CHECKED = false
                        } else {
                            result[i].CHECKED = true
                        }
                        this.items.push(result[i])  
                    }
                    
                }, res => {
                    // error callback
                    this.messages = "POST FAIL"
                })

                // get missed part
                formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_missed_parts/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.missed = result
                    
                }, res => {
                    // error callback
                    this.missed = "POST FAIL"
                })

                // get additional items
                formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_additional_items/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.additional = result
                    
                }, res => {
                    // error callback
                    this.missed = "POST FAIL"
                })

                // get last date
                formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_chdate/'
                this.$http.post(urllink, formData).then(res => {
                    //refresh the table
                    var result = res.body
                    this.chdate = result
                    
                }, res => {
                    // error callback
                    this.chdate = "POST FAIL"
                })

                // get pictures
                var dealerName =""
                for(var i=0; i<this.dealers.length; i++){
                    if(this.dealer == this.dealers[i].id){
                        dealerName = this.dealers[i].des
                    }
                }
                var formData = new FormData()
                formData.append('dealer_name', dealerName)
                formData.append('serial', this.serial)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_pictures/'
                var rooturl = "<?php echo base_Url(); ?>"
                
                this.$http.post(urllink, formData).then(res => {
                    
                    var result = res.body
                    this.picture_srcs = []
                    dealerName = dealerName.replace(/\s+/g, '_')
                    for(var i=0;i<result.length;i++){
                        // this.picture_srcs.push({id: i, src: result[i]})
                        this.picture_srcs.push({id: i, src: rooturl+'dealers/'+dealerName+'/'+this.serial+'/'+result[i]})  
                    }
                    
                }, res => {
                    // error callback
                    this.messages = "POST FAIL"
                })

            },
            removePicture: function(pic_id){
                for(var i=0; i<this.picture_srcs.length; i++){
                    if(this.picture_srcs[i].id == pic_id){
                        var pic_src = this.picture_srcs[i].src
                        var pic_index = i
                    }
                }
                // Delete it from server
                var formData = new FormData()
                formData.append('pic_src', pic_src)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/remove_picture/'
                
                this.$http.post(urllink, formData).then(res => {
                    var result = res.body
                    // Delete it from picture_srcs
                    this.picture_srcs.splice(pic_index, 1)
                    
                }, res => {
                    // error callback
                    this.messages = "POST FAIL"
                })

            },
            onSubmit: function (){

            }
        },
        mounted: function(){
            if(<?php echo $isSpecific; ?>){
                // this.messages = "I get a specific case."
                this.boat = <?php echo $boat_id; ?>;
                
                // get the boat by id
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/review/get_boat/'
                this.$http.post(urllink, formData).then(res => {
                    
                    var result = res.body;
                    this.missed = result.MISSED;
                    this.additional = result.ADDITIONAL;
                    this.chdate = result.CHDATE;
                    this.dealer = result.DEALER_ID;
                    
                    
                }, res => {
                    // error callback
                    this.messages = "Get boat failed"
                });

                // get check list
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/get_checklist/'
                this.$http.post(urllink, formData).then(res => {
                    
                    var result = res.body
                    this.items = []
                    for(var i=0;i<result.length;i++){
                        if(result[i].CHECKED == "0") {
                            result[i].CHECKED = false
                        } else {
                            result[i].CHECKED = true
                        }
                        this.items.push(result[i])  
                    }
                    
                }, res => {
                    // error callback
                    this.messages = "Get check list failed"
                });

                // get transporter
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/review/get_transporter/'
                this.$http.post(urllink, formData).then(res => {
                    
                    var result = res.body;
                    this.transporter = result.TP_NAME;
                    
                    
                }, res => {
                    // error callback
                    this.messages = "Get transporter failed"
                });

                // get pictures

                var formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/review/get_pictures/'
                var rooturl = "<?php echo base_Url(); ?>"
                
                this.$http.post(urllink, formData).then(res => {
                    
                    var result = res.body
                    this.picture_srcs = []
                    for(var i=0;i<result.length;i++){
                        this.picture_srcs.push({id: i, src: result[i]})
                      
                    }
                    
                }, res => {
                    // error callback
                    this.messages = "Get pictures failed"
                });

                // serial
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/review/get_serial/'
                this.$http.post(urllink, formData).then(res => {
                    
                    var result = res.body
                    this.boats = []
                    this.models = []
                    this.selectedBoats = []
                    for (var i=0; i<result.length; i++){
                        this.boats.push(result[i])
                        this.selectedBoats.push(result[i])
                        if(! this.models.includes(result[i].MODEL)){
                            this.models.push(result[i].MODEL)
                        }
                        
                    }
                    this.sortBoatBySerial()
                    
                }, res => {
                    // error callback
                    this.messages = "Get serial failed"
                })

            } else {
                // this.messages = "It is a general case."
            }
        }
    })
</script>

