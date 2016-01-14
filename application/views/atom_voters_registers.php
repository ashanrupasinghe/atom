<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>ICA ATOM</title>

    <meta name="viewport" content="width=device-width">

    <link href="<?php echo base_url(); ?>style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/dropzone.css" type="text/css" rel="stylesheet"/>
    <script src="<?php echo base_url(); ?>assets/js/dropzone.min.js"></script>
    <script src="<?php echo base_url(); ?>js/modernizr-2.5.3.min.js"></script>
    <style type="text/css">
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <!--			    <h1>Application Processing Fee for Students with Foreign Qualifications</h1>			  -->
        <!--<div class="alert alert-info"><p>Now updated to remove or add error or success classes when user changes a field. (<a href="http://alittlecode.com/jquery-form-validation-with-styles-from-twitter-bootstrap/#comment-461">Thanks Giedrius</a>!)</p></div>-->
    </div>
    <div class="row">
        <div id="sidebar" class="offset1 span3">
            <div class="well">
                <h2></h2>
                <ul class="nav nav-list">
                    <li><a href="<?php echo site_url();?>"><h3>Home</h3></a></li>
                    <li><a href="<?php echo site_url(); ?>/atom/get_voters_registry"><h3>Voters Registry</h3></a></li>
                    <li><a href="<?php echo site_url(); ?>/atomVoteController/index"><h3>Voters Registry 2</h3></a></li>
                </ul>

            </div>
            <!-- .well -->

        </div>
        <!-- .span -->

        <div id="maincontent" class="span8">

            <div class="tabbable">

                <div class="tab-content">
                    <div id="demo" class="tab-pane active">
                        <!--<div class="alert alert-success">
                            <h4>NOTES</h4>
                            <ul>
                                <li>To receive feedback, fill in a field and tab to the next. To get negative feedback, only enter one character.</li>
                                <li>For explanations, see the tabs above for the code, and of course <a href="http://docs.jquery.com/Plugins/Validation/"><strong>check out the plugin documentation</strong></a>.</li>
                            </ul>
                        </div> notes .alert -->
                        <div class="well">
                            <form action="<?php echo site_url('atom_voters/go_inside_voters_dir'); ?>" id="contact-form"
                                  class="form-horizontal" method="post">
                                <fieldset>
                                    <legend>ICA ATOM [Voters Registers]</legend>
                                    <?php if ($message != NULL) {
                                        echo '<div class="alert-success">
                                                                           <div class="control-group">' . $messagealert - success . '</div></div>';
                                    } ?>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Collection</label>

                                        <div class="controls">
                                            <select id="drop01" class="uni_list"
                                                    class="span2" <?php if ($validate == 1) {
                                                echo 'disabled';
                                            } ?>>
                                                <option value="">Department of Election</option>
                                                <option value="">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--disabled=""-->
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Series</label>

                                        <div class="controls">
                                            <select name="items_2" id="items_2" <?php if ($validate == 1) {
                                                echo 'disabled';
                                            } ?> class="series">
                                                <option value="">Select Voters Register</option>

                                                <?php
                                                foreach ($series as $s) { ?>
                                                    <option value="<?php echo $s['id']; ?>"><?php echo $s['title']; ?></option>
                                                <?php } ?>
                                            </select>

                                    </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">District</label>

                                        <div class="controls">
                                            <select name="items_3" id="items_3" class="series">
                                                <!--                                                              <option value="">Select the Districts</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Year</label>

                                        <div class="controls">
                                            <select name="items_4" id="items_4" class="series">
                                                <!--                                                              <option value="">Select years</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Polling Division</label>

                                        <div class="controls">
                                            <select name="items_5"
                                                    id="items_5                                                     "
                                                    class="series">
                                                <!--                                                              <option value="">Select Poling Division</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Polling District</label>

                                        <div class="controls">
                                            <select name="items_6" id="items_6" onchange="showDiv(this)" class="series">
                                                <!--                                                              <option value="">Select Poling District</option>
                                                                                                              <option value="1"> New Poling District</option>-->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group" id="hidden_div" name="hidden_div"
                                         style="visibility: hidden ;">
                                        <label class="control-label col-sm-2" for="name">Add Polling District</label>

                                        <div class="controls">
                                            <input type="text" id="polling" name="polling">
                                            <button type="button" class="btn-primary btn" id="btn" name="btn">Add
                                            </button>
                                        </div>
                                    </div>
                                    <div id="red" class="colors" style="display:none"> ....</div>
                                    <!--                                                        <select name="newuni" id="newuni" class="span2">
                                                                                            </select>-->
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Location</label>

                                        <div class="controls">
                                            <input type="text" id="level7" name="level7">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">Start House No</label>

                                        <div class="controls">
                                            <input type="text" id="level7_1" name="level7_1">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-sm-2" for="name">End House No</label>

                                        <div class="controls">
                                            <input type="text" id="level7_2" name="level7_2">
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary btn-large" id="btn" name="btn">
                                            Submit
                                        </button>
                                        <button type="reset" class="btn">Cancel</button>

                                        <!--                                                    <li><a href="<?php echo site_url(); ?>/atom/level_of_discription_id">test the query</a></li>-->
                                    </div>
                                </fieldset>
                            </form>
                            <!-- Dropzone Upload -->

                            <!--                                             <div class="alert-info">
                                                 <div class="control-group">
                                                 <label class="control-label" for="name">Digital objects</label>
					<div class="controls">
                                            <form action="<?php echo site_url('/dropzone/upload'); ?>" class="dropzone" enctype="multipart/form-data">
                                               	391  
                                              <input type="text" id="series1" name="series1" value="" >
                                              <input type="text" id="series2" name="series2" value="" >
                                              
                                                  
                                            </form>
                                            </div>
                                            </div>
                                                 </div>-->


                        </div>
                        <!--                                        <div class="well">

                                                                </div>-->

                        <!-- .tab-pane -->
                        <!-- .tab-pane -->
                        <!-- .tab-pane -->
                        <!-- .tab-pane -->

                    </div>
                    <!-- .tab-content -->
                </div>
                <!-- .tabbable -->

            </div>
            <!-- .span -->

        </div>
        <!-- .row -->
        <input type="text" class="input-xlarge" style="visibility:hidden " name="path" id="path"
               value="<?php echo site_url(); ?>">
        <hr>


    </div>
    <!-- .container -->

    <!-- ==============================================
             JavaScript below! 															-->

    <!-- jQuery via Google + local fallback, see h5bp.com -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

    <!-- Validate plugin -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

    <!-- Prettify plugin -->
    <script src="<?php echo base_url(); ?>assets/js/prettify/prettify.js"></script>

    <!-- Scripts specific to this page -->
    <script src="<?php echo base_url(); ?>script.js"></script>

    <script>
        // Activate Google Prettify in this page
        addEventListener('load', prettyPrint, false);

        $(document).ready(function () {

            // Add prettyprint class to pre elements
            $('pre').addClass('prettyprint linenums');

        });

    </script>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-22151549-3']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <script>
        $("#btn").click(function () {
            $("#clickme").show();
        });
    </script>
    <script>
        $("#items").change(function () {
            var selectedValue = $(this).val();
            $("#series2").val($(this).find("option:selected").attr("value"))
        });
    </script>

    <script>
        $("#series").change(function () {
            var selectedValue = $(this).val();
            $("#series1").val($(this).find("option:selected").attr("value"))
        });

    </script>
    <script>
        $('.series').on('change', function () {
            var d_code = this.value;
            var dropname = $(this).attr('id');
            var res = dropname.split("_");
            var id_last = res[res.length - 1];
            id_last++;
            //alert(id_last);
            var path = $("#path").val();
            //alert(d_code);
            $.getJSON(path + '/dropzone/get_itemList/' + d_code, function () {
                //alert("success");
            })
                .success(function (j) {
//alert(j[4].GSDiv_name_en);
                    var options_list = '';
                    options_list += '<option  value="">Please select</option>';
                    //options_list += '<option  value="1">Add New</option>';
                    //options_list[0]= '<option value="' '">' '</option>';
                    for (var i = 0; i < j.length; i++) {
                        options_list += '<option value="' + j[i].id + '">' + j[i].identifier + '</option>';
                    }
                    if (id_last == 6) {
                        options_list += '<option  value="1">Add new</option>';
                    }
                    $("#series2").val(j[0].id);
                    $("select#items_" + id_last).html(options_list);
                })
                .error(function () { /*alert("error");*/
                })
                .complete(function () { /*alert("complete");*/
                });
        });

    </script>
    <script>

        function showDiv(elem) {
            if (elem.value == 1) {
                document.getElementById('hidden_div').style.visibility = 'visible';
            }
            else {
                document.getElementById('hidden_div').style.visibility = 'hidden';
            }
        }

    </script>
</body>
</html>
