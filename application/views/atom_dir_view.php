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
                    <li><a href="<?php echo site_url(); ?>/atom/get_home"><h2>Home</h2></a></li>
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
                            <!--                                            used to get passed variables from home-->


                            <!-- Dropzone Upload -->
                            <?php if ($message != NULL) {
                                echo '<div class="alert-danger">
                                                <div class="control-group">' . $message . '</div></div>';
                            } ?>
                            <div class="alert-success">
                                <div class="control-group">
                                    <!--                      <input type="text" id="items1" name="items12" value="<?php echo $iteam_id; ?>">-->
                                    <?php

                                    $this->load->helper('url');
                                    $script = site_url('atom/go_inside');
                                    //$base = dirname(__FILE__);
                                    //C:\Users\ucsc\Pictures\326-IM-0156

                                    $base = $this->config->item('atom_upload_path');
                                    //$path = empty($_REQUEST['path']) ? '' : $_REQUEST['path'];
                                    $path = $this->input->get('path');

                                    //print_r($path);

                                    $p = $base . DIRECTORY_SEPARATOR . $path;

                                    echo 'Current Directory:' . $path . '<br>';
                                    echo 'Current Directory:' . $p . '<br>';

                                    $directories = array();
                                    $files = array();

                                    if (is_dir($p)) {
                                        if ($dh = opendir($p)) {
                                            while (false !== $item = readdir($dh)) {
                                                if ('.' === $item) {
                                                    continue;
                                                } else if ('..' === $item) {
                                                    array_push($directories, dirname($path));
                                                } else {
                                                    if (!empty($path))
                                                        $item = $path . DIRECTORY_SEPARATOR . $item;
                                                    if (is_dir($base . DIRECTORY_SEPARATOR . $item)) {
                                                        array_push($directories, $item);
                                                    } else {
                                                        array_push($files, $item);
                                                    }
                                                }
                                            }
                                            closedir($dh);
                                        } else {
                                            echo '<p class="error">Directory could not be opened.</p>';
                                        }
                                    } else {
                                        echo '<p class="error">Path is not a directory.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="alert-success">
                                <div class="control-group">
                                    <h2>Directories</h2>
                                    <?php
                                    foreach ($directories as $directory) {
                                        if ('.' === $directory) {
                                            echo "<a href='{$script}?&item={$iteam_id}&series={$series_id}'>Back</a><br>";
                                        } else {
                                            echo "<a href='{$script}?path={$directory}&item={$iteam_id}&series={$series_id}'>{$directory}</a><br>";
                                        }
                                    }
                                    ?>
                                    <!--<h2>Files</h2>
		                            <?php
                                    foreach ($files as $file) {
                                        $basename = basename($file);
                                        $file = str_replace('\\', '/', $file);
                                        echo "<a href='{$file}'>{$basename}</a><br>";
                                    }
                                    ?>-->
                                    <div class="control-group">

                                        <h2>File Selection</h2>

                                        <form name="form" method="post"
                                              action="<?php echo site_url('/atom/get_selected_iteams'); ?>"
                                              method="post">
                                            <input type="hidden" name="path" value="<?php echo $path ?>">

                                            <select name="files[]" multiple="multiple" id="files" class="span3">
                                                <?php
                                                foreach ($files as $file) {
                                                    $basename = basename($file);
                                                    $file = str_replace('\\', '/', $file);
                                                    echo "<option value='{$file}'>{$basename}</option>";
                                                }
                                                ?>
                                            </select>
                                            <input type="text" id="series123" name="series123"
                                                   value="<?php echo $series_id; ?>" style="visibility:hidden">
                                            <input type="text" id="items1" name="items1"
                                                   value="<?php echo $iteam_id; ?>" style="visibility:hidden">

                                            <div>
                                                <button type="button" class="btn btn-primary btn-success" id="btn1"
                                                        name="btn1">Select All
                                                </button>
                                            </div>

                                            <div class="controls">
                                                <div class="well">
                                                    <div class="alert-success">
                                                        <button type="submit" class="btn btn-primary btn-large" id="btn"
                                                                name="btn">Upload
                                                        </button>
                                                        <!--                             <button  class="btn btn-primary btn-success" id="btn1" name="btn1" >Select All</button>-->
                                                        <!--			<button type="submit">Upload</button>-->
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                                                 </div>-->


                    </div>


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
    $('#series').on('change', function () {

        var d_code = this.value;

        var path = $("#path").val();

        //alert(d_code);
        $.getJSON(path + '/dropzone/get_itemList/' + d_code, function () {
            //alert("success");
        })
            .success(function (j) {
//alert(j[4].GSDiv_name_en);
                var options_list = '';

                //options_list[0]= '<option value="' '">' '</option>';
                for (var i = 0; i < j.length; i++) {
                    options_list += '<option value="' + j[i].id + '">' + j[i].identifier + '</option>';
                }
                $("#series2").val(j[0].id);
                $("select#items").html(options_list);
            })
            .error(function () { /*alert("error");*/
            })
            .complete(function () { /*alert("complete");*/
            });


    });

</script>
<script>
    $('#btn1').click(function () {
        $('#files option').prop('selected', true);
    });
</script>
</body>
</html>
