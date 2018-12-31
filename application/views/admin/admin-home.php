<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:200px;margin-top:43px;">

    <!-- Header -->
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
        <a class="w3-quarter links" href="<?= base_url('admin/hostels');?>">
            <div class="w3-container w3-blue w3-padding-16">
                <div class="w3-left"><i class="fa fa-bed w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3>
                        <?= $number['hostels'];?>
                    </h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Hostels</h4>
            </div>
        </a>
        <a class="w3-quarter links" href="<?= base_url('admin/users');?>">
            <div class="w3-container w3-orange w3-text-white w3-padding-16">
                <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                <div class="w3-right">
                    <h3>
                        <?= $number['users'];?>
                    </h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Users</h4>
            </div>
        </a>
    </div>

    <br>
    <div class="w3-panel">
        <div class="w3-row-padding">
            <div id="myChart">
                
            </div>
        </div>
    </div>

    <!-- End page content -->
</div>
<script>
    var myData=[<?php
        foreach($graph->result_array() as $label){
            echo '"'.$label['vacancies'].'",';/* We use the concatenation operator '.' to add comma delimiters after each data value. */
        }?>];
  
        console.log(myData);
  
    var myLabels=[<?php
        foreach($graph->result_array() as $label){
            echo '"'.$label['hostel_name'].'",'; /* The concatenation operator '.' is used here to create string values from our database names. */
        }?>];

        console.log(myLabels);
        
    window.onload=function(){
        zingchart.render({
            id:"myChart",
            width:"100%",
            height:400,
            data:{
                "type":"bar",
                "title":{
                    "text":"Hostels and their availablity"
                },
                "scale-x":{
                    "labels":myLabels
                },
                "series":[
                    {
                        "values":myData
                    }
                ]
            }
        });
    };
</script>