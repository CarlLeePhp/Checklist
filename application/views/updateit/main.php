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
                <select name="transporter" class="form-control" v-model="transporter" @change="modelHandler">
                    <option v-for="transporter in transporters" :value="transporter.id">{{ transporter.name }}</option>
	            </select>
            </div>
            <button class="btn btn-success" @click="update_transporter">Save</button>
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
                    <td><input type="checkbox" v-model="item.CHECKED"></td>
                    
                </tr>
                
            </tbody>
        </table>
    </div>
    <br />
    <div class="d-flex justify-content-center">
        <button class="btn btn-success" @click="update_checklist">Save Checklist</button>
    </div>
    <br />
    <!-- Check List Table End -->

    <!-- Missed Parts -->
    <div class="form-row">
        <div class="form-goup offset-md-2 col-md-8">
            <label for="missed">Missing Items</label>
            <textarea name="missed" class="form-control" row="5" v-model="missed"> </textarea>
        </div>
    </div>
    <br />
    <div class="d-flex justify-content-center">
        <button class="btn btn-success" @click="update_missed">Save Missed Parts Information</button>
    </div>
    <br />
    <!-- Missed Parts End -->

    <!-- Additional Items -->
    <div class="form-row">
        <div class="form-goup offset-md-2 col-md-8">
            <label for="additional">Additional Items</label>
            <textarea name="additional" class="form-control" row="5" v-model="additional"> </textarea>
        </div>
    </div>
    <br />
    <div class="d-flex justify-content-center">
        <button class="btn btn-success" @click="update_additional">Save Additional Items Information</button>
    </div>
    <br />
    <!-- Additional Items End -->

    <h4 class="text-center">Pictures</h4>
    <hr />
    <div class="d-flex align-content-start flex-wrap">
        <div class="col-md-4 mb-2" v-for="item in picture_srcs" :key="item.id">
            <img :src="item.src" class="img-fluid" />
            <a href="#" class="text-danger" @click.stop.prevent="deletePicture(item.id)">Delete</a>
        </div>
        <div class="col-md-4 mb-2" v-for="item in more_picture_srcs" :key="item.id">
            <img :src="item.src" class="img-fluid" />
            <a href="#" class="text-warning" @click.stop.prevent="removePicture(item.name)">Delete</a>
        </div>
        
    </div>
    <br />

    <!-- More Pictures -->
    <div class="d-flex justify-content-center">
            <!-- Choose Picture and preview, cannot cancel any picture -->
            <input type="file" name="userfile" id="userfile" @change="choose_picture" multiple="multiple">
    </div>
    <br />
    <div class="d-flex justify-content-center">
        <button class="btn btn-success" @click="upload_picture">Upload Pictures</button>
        <button class="btn btn-warning ml-2" @click="create_email">Send Email</button>
    </div>
    <input type="hidden" name="img_val" id="img_val" value="" />
    <!-- More Pictures End -->

    <!-- A Modal -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>{{ messages }}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
    <!-- A Modal End -->

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
            transporter: "", // transporter id
            transporters: [
                <?php foreach ($transporters as $transporter): ?>
                    {id: "<?php echo $transporter['TP_ID'] ?>", name: "<?php echo $transporter['TP_NAME'] ?>"},
                <?php endforeach; ?>
            ],
            items: [{CL_ID: 0, BOAT_ID: 0, CL_DES: "", CHECKED: 0, TYPE: ""}],
            userfiles: [], // Upload pictures, Array
            picture_srcs: [
                {id: 0, src: ""}
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
            boatHandler: function(){
                // set the transporter and serial
                for(var i=0; i<this.boats.length; i++){
                    if(this.boat == this.boats[i].BOAT_ID){
                        
                        for(var j=0; j<this.transporters.length; j++){
                            if(this.boats[i].TP_NAME == this.transporters[j].name){
                                this.transporter = this.transporters[j].id
                            }
                        }
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
                    this.additional = "POST FAIL"
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
                    //refresh the table
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

                // clear more_pictures
                this.more_picture_srcs = []
                this.userfiles = []

            },
            update_checklist: function(){
                // update checklist
                for(var i=0; i<this.items.length; i++){
                    var formData = new FormData()
                    formData.append('cl_id', this.items[i].CL_ID)
                    formData.append('checked', this.items[i].CHECKED)
                    var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/update_list/'
                    this.$http.post(urllink, formData).then(res => {
                        var result = res.body
                        
                    }, res => {
                        // error callback
                        
                        
                    })
                }

                // update the chdate
                formData = new FormData()
                formData.append('boat_id', this.boat)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/update_chdate/'
                this.$http.post(urllink, formData).then(res => {
                    // success call back
                    var result = res.body
                    var d = new Date();
                    this.chdate = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate()
                    this.messages = "Check List was updated successfully";
                    $('#myModal').modal('show')
                    
                }, res => {
                    // error callback
                    this.messages = "Check List was updated failed";
                    $('#myModal').modal('show')
                })
                
            },
            update_missed: function(){
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                formData.append('missed', this.missed)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/update_missed/'
                this.$http.post(urllink, formData).then(res => {
                    // success callback
                    var result = res.body
                    var d = new Date();
                    this.chdate = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate()
                    this.messages = result;
                    $('#myModal').modal('show')
                }, res => {
                    // error callback
                    this.messages = "Missed parts information was updated failed";
                    $('#myModal').modal('show')
                })
            },
            update_additional: function(){
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                formData.append('additional', this.additional)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/update_additional/'
                this.$http.post(urllink, formData).then(res => {
                    // success callback
                    var result = res.body
                    var d = new Date();
                    this.chdate = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate()
                    this.messages = result;
                    $('#myModal').modal('show')
                }, res => {
                    // error callback
                    this.messages = "Additional information was updated failed";
                    $('#myModal').modal('show')
                })
            },
            update_transporter: function(){
                var formData = new FormData()
                formData.append('boat_id', this.boat)
                formData.append('transporter', this.transporter)
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/updateit/update_transporter/'
                this.$http.post(urllink, formData).then(res => {
                    // success callback
                    var result = res.body
                    var d = new Date();
                    this.chdate = d.getFullYear() + "-" + d.getMonth() + "-" + d.getDate()
                    this.messages = result;
                    $('#myModal').modal('show')
                }, res => {
                    // error callback
                    this.messages = "Transporter was updated failed";
                    $('#myModal').modal('show')
                })
            },
            choose_picture: function(){
                var userfile = document.getElementById("userfile")
                var len = userfile.files.length
                for(var i=0; i<len; i++){
                    this.userfiles.push(userfile.files[i])
                }
                this.more_picture_srcs =[]
                var tempList=[]
                var j = 100
                for(var i=0; i<this.userfiles.length;i++){
                    let file_name = this.userfiles[i].name
                    try {
                        
                        var reader = new FileReader();
                        reader.readAsDataURL(this.userfiles[i])
                        reader.onload = function(e){
                            var result = e.target.result
                            var pic_src = {id: j, src: result, name: file_name}
                            tempList.push(pic_src)
                            j++
                        }
                    } catch (e) {
                        console.log(e)
                    }
                    this.more_picture_srcs = tempList
                }
            },
            upload_picture: function(){
                // upload pictures
                for(var i=0; i<this.userfiles.length;i++){
                
                    var formData = new FormData()
                    formData.append('user_file', this.userfiles[i])
                    formData.append('dealer_id', this.dealer)
                    formData.append('serial', this.serial)
                    var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/get_file/'
                    this.$http.post(urllink, formData).then(res => {
                        var result = res.body
                    
                    }, res => {
                        // error callback
                        this.messages = "Pictures were uploaded failed";
                        $('#myModal').modal('show')
                    })
                }
                this.messages = "Pictures were uploaded successfully";
                $('#myModal').modal('show')
            },
            deletePicture: function(pic_id){
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
                    this.messages = "Remove picture failed"
                })

            },
            create_email: function(){
                
                var formData = new FormData()
                formData.append('dealer_id', this.dealer)
                formData.append('serial', this.serial)
                formData.append('model_id', this.model)
                formData.append('email_type', "Updated")
                var urllink = "<?php echo base_Url(); ?>" + 'index.php/pages/create_email/'
                this.$http.post(urllink, formData).then(res => {
                    var result = res.body
                    this.messages = result;
                    $('#myModal').modal('show')
                }, res => {
                    // error callback
                    var result = res.body
                    this.messages = result;
                    $('#myModal').modal('show')
                })
            },
            onSubmit: function (){

            },
            removePicture: function(pic_name){
                
                for(var i=0; i<this.more_picture_srcs.length; i++){
                    if(this.more_picture_srcs[i].name == pic_name){
                        this.more_picture_srcs.splice(i, 1)
                        
                    }
                }
                
                
                for (var i=0; i<this.userfiles.length; i++){
                    if(this.userfiles[i].name == pic_name){
                        this.userfiles.splice(i, 1)
                    }
                }
            }
        }
    })
</script>

