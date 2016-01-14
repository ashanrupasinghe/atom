<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Atom_Voters extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //$this->load->helper('url');
        $this->load->helper(array('url', 'html', 'form'));
        //$this->load->model('manageStudents');
         $this->load->model('atommodel');
        //$result['list']=$this->model->getSeries();
        //$this->load->view('top');
        //$this->load->view('atom_voters_registers',$result);
    }

    function go_inside_voters_dir(){
        
        $this->data['iteam_id']=$this->input->post('items_6');
        $this->data['series_id']=$this->input->post('level7');
        $this->data['start_house']=$this->input->post('level7_1');
        $this->data['end_house']=$this->input->post('level7_2');
        $this->data['polling']=$this->input->post('polling');
        $this->data['pdivision']=$this->input->post('items_5');
        $this->data['message']=Null;
        $this->load->view('atom_voters_dir_view',$this->data);
        
    }
    function go_inside_voters_files(){
        
        $this->data['message']=Null;
        $this->data['series_id']=$this->input->get('series');
        $this->data['iteam_id']=$this->input->get('item');
        $this->data['start_house']=$this->input->get('shouse');
        $this->data['end_house']=$this->input->get('ehouse');
        $this->data['polling']=$this->input->get('pol');
        $this->data['pdivision']=$this->input->get('pd');
        $this->load->view('atom_voters_dir_view',$this->data);
    }

    function get_voters_registry(){
        $l=488;
        $this->data['series_id']=0;
        $this->data['series_id']=0;
        $this->data['message']=NULL;
        $this->data['series']=$this->atommodel->get_series_forvoters();
        $this->data['items']=$this->atommodel->get_subjects($l);
        $this->data['validate']=0;
        $this->load->view('atom_voters_registers',$this->data);//sfb
    }
    
    function level_of_discription_id(){
        
//         $tt=$this->atommodel->get_series();
//         //$ss=$tt['id'];
        $series_id=391;
        $rgtarray=$this->atommodel->get_rgt($series_id);
        $lft=$rgtarray[0]['rgt'];
         var_dump($lft);
    }

  function add_voters_level_seven($series_no2,$entername){
      
       $date = date('Y-m-d H:i:s');
                //insert Level seven(object table)
                $k=0;

                                    $data = array(               
                                    'class_name'              => 'QubitInformationObject',
                                    'created_at'              => $date,
                                    'updated_at'              => $date,
                                    'serial_number'           => $k,
                                     );
                $parent_id=$this->atommodel->add_post($data);
                //insert subject(information_object)
                                                                //get the Identifier(get the name )
//                                                                $farray = explode("-", $fileName);
//                                                                $dotarray = explode(".", end($farray));
//                                                                $identifier=$dotarray[0];
                                                                
                                                                //get level_of_discription_id
                                                                $tt=$this->atommodel->level_of_discription_id();
                                                                $level_of_description_id=$tt['id'];
                                                                
                                                                //get parent_id(selected subject id)
                                                                //391
                                                                //should get it from the dropdown lis(information object tabel ID colum)
                                                                //$series_no2
                                                                
                                                                //get rgt for title
                                                                $rgtarray=$this->atommodel->get_rgt($series_no2);
                                                                $lft=$rgtarray['rgt'];
                                                                
                                                                //$parent_rgt=$rgtarray['rgt'];
                                                                $rgt=$lft+1;
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                $this->atommodel->update_all_rgt($lft);
              //$lft=0;
              //$rgt=0;
                
                $data1 = array(               
                                    'id'                        => $parent_id,
                                    'identifier'                => $entername,
                                    'level_of_description_id'   => $level_of_description_id,
                                    'parent_id'                 => $series_no2,
                                    'source_standard'           => 'ISAD(G) 2nd edition',
                                    'lft'                       => $lft,
                                    'rgt'                       => $rgt,
                                    'source_culture'            => 'en',
                                     );
                $this->atommodel->add_information_objects($data1);
                
                //insert subject(information_object_i18n)
                //title / extent_and_medium = Unspecified / id
                                                                    //get the titel from the subject title
                                                                        $id=394;
                                                                        $itemsArray=$this->atommodel->get_title_of_subject($id);
                                                                        $title=$itemsArray['title'];
                                                                        
                                                                        
                
                $data2 = array(               
                                    'title'                   => $entername,
                                    'extent_and_medium'       => 'Unspecified',
                                    'id'                      => $parent_id,
                                    'culture'                 => 'en',
                                     );
                $this->atommodel->add_information_object_i18n($data2);
                                                                        //get the slug name for title
                                                                       // $slagrray = explode(".", $fileName);
                                                                        $slagtitle=$entername.'-'.$parent_id;
                //insert title of the image(slug)
                $data3 = array(               
                                    'object_id'               => $parent_id,
                                    'slug'                    => $slagtitle,
                                    'serial_number'           => '0',
                                     );
                $this->atommodel->add_slug($data3);
                
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                //$this->atommodel->update_all_rgt($parent_rgt);
                
                //$this->insert_digital_object($parent_id);
                
                //insert title of image to status table(draft=status_id=159)
                $data7 = array(               
                                    'object_id'                 => $parent_id,
                                    'type_id'                   => '158',
                                    'status_id'                 => '160',
                                    'serial_number'             => '0',
                                     );
                
                $this->atommodel->add_status($data7);
                return $parent_id;
      
  }
  function add_start_end_house($series_no2,$entername,$start_house,$end_house, $val_level7){
      
      
      $item_name=$start_house._.$end_house;
      $series_no2=$val_level7;
       $date = date('Y-m-d H:i:s');
                //insert Level seven(object table)
                $k=0;

                                    $data = array(               
                                    'class_name'              => 'QubitInformationObject',
                                    'created_at'              => $date,
                                    'updated_at'              => $date,
                                    'serial_number'           => $k,
                                     );
                $parent_id=$this->atommodel->add_post($data);
                //insert subject(information_object)
                                                                //get the Identifier(get the name )
//                                                                $farray = explode("-", $fileName);
//                                                                $dotarray = explode(".", end($farray));
//                                                                $identifier=$dotarray[0];
                                                                
                                                                //get level_of_discription_id
                                                                $tt=$this->atommodel->level_of_discription_id();
                                                                $level_of_description_id=$tt['id'];
                                                                
                                                                //get parent_id(selected subject id)
                                                                //391
                                                                //should get it from the dropdown lis(information object tabel ID colum)
                                                                //$series_no2
                                                                
                                                                //get rgt for title
                                                                $rgtarray=$this->atommodel->get_rgt($series_no2);
                                                                $lft=$rgtarray['rgt'];
                                                                
                                                                //$parent_rgt=$rgtarray['rgt'];
                                                                $rgt=$lft+1;
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                $this->atommodel->update_all_rgt($lft);
              //$lft=0;
              //$rgt=0;
                
                $data1 = array(               
                                    'id'                        => $parent_id,
                                    'identifier'                => $item_name,
                                    'level_of_description_id'   => $level_of_description_id,
                                    'parent_id'                 => $series_no2,
                                    'source_standard'           => 'ISAD(G) 2nd edition',
                                    'lft'                       => $lft,
                                    'rgt'                       => $rgt,
                                    'source_culture'            => 'en',
                                     );
                $this->atommodel->add_information_objects($data1);
                
                //insert subject(information_object_i18n)
                //title / extent_and_medium = Unspecified / id
                                                                    //get the titel from the subject title
                                                                        $id=394;
                                                                        $itemsArray=$this->atommodel->get_title_of_subject($id);
                                                                        $title=$itemsArray['title'];
                                                                        
                                                                        
                
                $data2 = array(               
                                    'title'                   => $entername,
                                    'extent_and_medium'       => 'Unspecified',
                                    'id'                      => $parent_id,
                                    'culture'                 => 'en',
                                     );
                $this->atommodel->add_information_object_i18n($data2);
                                                                        //get the slug name for title
                                                                       // $slagrray = explode(".", $fileName);
                                                                        $slagtitle=$entername.'-'.$parent_id;
                //insert title of the image(slug)
                $data3 = array(               
                                    'object_id'               => $parent_id,
                                    'slug'                    => $slagtitle,
                                    'serial_number'           => '0',
                                     );
                $this->atommodel->add_slug($data3);
                
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                //$this->atommodel->update_all_rgt($parent_rgt);
                
                //$this->insert_digital_object($parent_id);
                
                //insert title of image to status table(draft=status_id=159)
                $data7 = array(               
                                    'object_id'                 => $parent_id,
                                    'type_id'                   => '158',
                                    'status_id'                 => '160',
                                    'serial_number'             => '0',
                                     );
                
                $this->atommodel->add_status($data7);
                return $parent_id;
      
  }
  
  function add_new_poling_district($series_no2,$entername){
      
       $date = date('Y-m-d H:i:s');
                //insert Level seven(object table)
                $k=0;

                                    $data = array(               
                                    'class_name'              => 'QubitInformationObject',
                                    'created_at'              => $date,
                                    'updated_at'              => $date,
                                    'serial_number'           => $k,
                                     );
                $parent_id=$this->atommodel->add_post($data);
                //insert subject(information_object)
                                                                //get the Identifier(get the name )
//                                                                $farray = explode("-", $fileName);
//                                                                $dotarray = explode(".", end($farray));
//                                                                $identifier=$dotarray[0];
                                                                
                                                                //get level_of_discription_id
                                                                $tt=$this->atommodel->level_of_discription_id();
                                                                $level_of_description_id=$tt['id'];
                                                                
                                                                //get parent_id(selected subject id)
                                                                //391
                                                                //should get it from the dropdown lis(information object tabel ID colum)
                                                                //$series_no2
                                                                
                                                                //get rgt for title
                                                                $rgtarray=$this->atommodel->get_rgt($series_no2);
                                                                $lft=$rgtarray['rgt'];
                                                                
                                                                //$parent_rgt=$rgtarray['rgt'];
                                                                $rgt=$lft+1;
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                $this->atommodel->update_all_rgt($lft);
              //$lft=0;
              //$rgt=0;
                
                $data1 = array(               
                                    'id'                        => $parent_id,
                                    'identifier'                => $entername,
                                    'level_of_description_id'   => $level_of_description_id,
                                    'parent_id'                 => $series_no2,
                                    'source_standard'           => 'ISAD(G) 2nd edition',
                                    'lft'                       => $lft,
                                    'rgt'                       => $rgt,
                                    'source_culture'            => 'en',
                                     );
                $this->atommodel->add_information_objects($data1);
                
                //insert subject(information_object_i18n)
                //title / extent_and_medium = Unspecified / id
                                                                    //get the titel from the subject title
                                                                        $id=394;
                                                                        $itemsArray=$this->atommodel->get_title_of_subject($id);
                                                                        $title=$itemsArray['title'];
                                                                        
                                                                        
                
                $data2 = array(               
                                    'title'                   => $entername,
                                    'extent_and_medium'       => 'Unspecified',
                                    'id'                      => $parent_id,
                                    'culture'                 => 'en',
                                     );
                $this->atommodel->add_information_object_i18n($data2);
                                                                        //get the slug name for title
                                                                       // $slagrray = explode(".", $fileName);
                                                                        $slagtitle=$entername.'-'.$parent_id;
                //insert title of the image(slug)
                $data3 = array(               
                                    'object_id'               => $parent_id,
                                    'slug'                    => $slagtitle,
                                    'serial_number'           => '0',
                                     );
                $this->atommodel->add_slug($data3);
                
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                //$this->atommodel->update_all_rgt($parent_rgt);
                
                //$this->insert_digital_object($parent_id);
                
                //insert title of image to status table(draft=status_id=159)
                $data7 = array(               
                                    'object_id'                 => $parent_id,
                                    'type_id'                   => '158',
                                    'status_id'                 => '160',
                                    'serial_number'             => '0',
                                     );
                
                $this->atommodel->add_status($data7);
                return $parent_id;
      
  }
    function add_voters_level_six($series_no2,$entername){
      
       $date = date('Y-m-d H:i:s');
                //insert Level seven(object table)
                $k=0;

                                    $data = array(               
                                    'class_name'              => 'QubitInformationObject',
                                    'created_at'              => $date,
                                    'updated_at'              => $date,
                                    'serial_number'           => $k,
                                     );
                $parent_id=$this->atommodel->add_post($data);
                //insert subject(information_object)
                                                                //get the Identifier(get the name )
//                                                                $farray = explode("-", $fileName);
//                                                                $dotarray = explode(".", end($farray));
//                                                                $identifier=$dotarray[0];
                                                                
                                                                //get level_of_discription_id
                                                                $tt=$this->atommodel->level_of_discription_id();
                                                                $level_of_description_id=$tt['id'];
                                                                
                                                                //get parent_id(selected subject id)
                                                                //391
                                                                //should get it from the dropdown lis(information object tabel ID colum)
                                                                //$series_no2
                                                                
                                                                //get rgt for title
                                                                $rgtarray=$this->atommodel->get_rgt($series_no2);
                                                                $lft=$rgtarray['rgt'];
                                                                
                                                                //$parent_rgt=$rgtarray['rgt'];
                                                                $rgt=$lft+1;
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                $this->atommodel->update_all_rgt($lft);
              //$lft=0;
              //$rgt=0;
                
                $data1 = array(               
                                    'id'                        => $parent_id,
                                    'identifier'                => $entername,
                                    'level_of_description_id'   => $level_of_description_id,
                                    'parent_id'                 => $series_no2,
                                    'source_standard'           => 'ISAD(G) 2nd edition',
                                    'lft'                       => $lft,
                                    'rgt'                       => $rgt,
                                    'source_culture'            => 'en',
                                     );
                $this->atommodel->add_information_objects($data1);
                
                //insert subject(information_object_i18n)
                //title / extent_and_medium = Unspecified / id
                                                                    //get the titel from the subject title
                                                                        $id=394;
                                                                        $itemsArray=$this->atommodel->get_title_of_subject($id);
                                                                        $title=$itemsArray['title'];
                                                                        
                                                                        
                
                $data2 = array(               
                                    'title'                   => $entername,
                                    'extent_and_medium'       => 'Unspecified',
                                    'id'                      => $parent_id,
                                    'culture'                 => 'en',
                                     );
                $this->atommodel->add_information_object_i18n($data2);
                                                                        //get the slug name for title
                                                                       // $slagrray = explode(".", $fileName);
                                                                        $slagtitle=$entername.'-'.$parent_id;
                //insert title of the image(slug)
                $data3 = array(               
                                    'object_id'               => $parent_id,
                                    'slug'                    => $slagtitle,
                                    'serial_number'           => '0',
                                     );
                $this->atommodel->add_slug($data3);
                
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                //$this->atommodel->update_all_rgt($parent_rgt);
                
                //$this->insert_digital_object($parent_id);
                
                //insert title of image to status table(draft=status_id=159)
                $data7 = array(               
                                    'object_id'                 => $parent_id,
                                    'type_id'                   => '158',
                                    'status_id'                 => '160',
                                    'serial_number'             => '0',
                                     );
                
                $this->atommodel->add_status($data7);
                return $parent_id;
      
  }
  //insert voters digital objects
   function voters_selected_iteams(){
        //
        //$data['path']=$this->input->get('path');
        $series_no2=$this->input->post('items1');
        $entername=$this->input->post('series123');
        $start_house=$this->input->post('level7_1');
        $end_house=$this->input->post('level7_2');
        $polling=$this->input->post('polling');
        $pdivision=$this->input->post('pdivision');
        
        if($polling=1){
            //add_voters_level_six($series_no2,$entername)
            $series_no2=$this->add_voters_level_six($pdivision,$entername);
        }
        
       //Insert level 07 to the system
        
        
        $val_level7=$this->add_voters_level_seven($series_no2,$entername);
        $val=$this->add_start_end_house($series_no2,$entername,$start_house,$end_house, $val_level7);
        
        
        var_dump($val);
        var_dump($val_level7);
        $this->data['message']=NULL;
        $script = site_url().basename(__FILE__);
        
			$base = 'C:\Users\ucsc\Pictures';
			$path = $_POST['path'];
			$p = $base.DIRECTORY_SEPARATOR.$path;
                        
                        //$base.DIRECTORY_SEPARATOR
			//echo 'Selected Path: '.$path.'<br>';
			//echo 'Selected Path: '.$p.'<br>';
			if(empty($_POST['files'])) {
				echo 'Files not selected... Use directory.';
                                $this->data['series_id']=$this->input->post('series123');
                                $this->data['iteam_id']=$this->input->post('items1');
                                $this->data['message']='Please select the Digital Images';
                                $this->load->view('atom_dir_view',$this->data);
			}
			else {
				//echo '<h2>Selected Files</h2>';
				if(isset($_POST['files'])) {
					foreach($_POST['files'] as $file) {
						//echo $file.'<br>';
                $folderName='folder'; 
                //$tempFile = $_FILES['file']['tmp_name'];
//                $fileName = $_FILES['file']['name'];
                $fileName =$file;
                $basename = basename($file);
                 $series_no= $this->input->post('series1');
                //class_name=QubitDigitalObject / created_at='2015-05-19 00:06:12' / updated_at=dateTime / serial_number=0
                //Insert into object table                
                 $originPath=$base.DIRECTORY_SEPARATOR.$file;
                 $from=str_replace('\\', '/', $originPath);
                //Create folders
                $date ='folder';
                $tt='doc1';
                $str = hash( "sha256", $fileName );
                $folder1='r';
                $folder2='null';
                $folder3=substr($str,0,1);
                $folder4=substr($str,1,1);
                $folder5=substr($str,2,1);
                
                //create folders

                if (!is_dir('uploads/'. $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str)) {
                    mkdir('./uploads/' . $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str, 0777, TRUE);

                }
                $targetPath = getcwd(). '/uploads/'. $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str.'/';
                $folderPath= '/uploads/'. $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str.'/';
                $targetFile = $targetPath.$basename;
                $to=str_replace('\\', '/', $targetFile);
                //move_uploaded_file($tempFile, $targetFile);
                
                //Insert Title of the image $str,$targetPath,$fileName  
                $series_no2=$val;
                $entername=$this->input->post('series123');
                $this->insert_images_for_voters($str,$targetPath,$basename, $series_no2,$folderPath,$entername);
               
                
                copy($from, $to);
                echo $from.'<br>';
                echo $to.'<br>';
                
                
	$l=391;	}
//        $this->data['message']="File Uploded Successfully!";
//        $this->data['series']=$this->atommodel->get_series();
//        $this->data['items']=$this->atommodel->get_subjects($l);
//        $this->data['validate']=0;
//        $this->load->view('atom_home',$this->data);
				}
			}
        //$this->load->view('dnfba');
    }
    function insert_images_for_voters($str,$targetPath,$fileName,$series_no2,$folderPath,$entername){

                $date = date('Y-m-d H:i:s');
                //insert title(object table)
                $parent_id=$series_no2;
                $k=0;
                $data4 = array(               
                                    'class_name'              => 'QubitDigitalObject',
                                    'created_at'              => $date,
                                    'updated_at'              => $date,
                                    'serial_number'           => $k,
                                     );
                $parent_image_id=$this->atommodel->add_post($data4);
                
                // id/ information_object_id / mime_type=image/tiff / media_type_id=136 
                // / name= filname / path=path / byte_size = size / checksum =hash val / checksum_type= sha256
                // lft=0 / rgt = 0 ($str,$targetPath,$fileName)
                
                //insert image to digital_object as a new row
                                                                //cretat target path without first section 
                                                                //$output = array_slice($input, 2);\
                                                                //implode('',$fruits);
                
                                                                
                 $data5 = array(               
                                    'id'                      => $parent_image_id,
                                    'information_object_id'   => $parent_id,
                                    'mime_type'               => 'image/tiff',
                                    'name'                    => $fileName,
                                    'path'                    => $folderPath,
                                    'byte_size'               => '100',
                                    'checksum'                => $str,
                                    'checksum_type'           => 'sha256',
                                    'lft'                     => '0',
                                    'rgt'                     => '0',
                                     );
                $this->atommodel->add_digital_object($data5);
                
                //insert image(slug)
                
                                                                //get the Identifier
                                                                $sarray = explode(".", $fileName);
                                                                $slag=$sarray[0].'-'.end($sarray).'-'.$parent_image_id;
                $data6 = array(               
                                    'object_id'               => $parent_image_id,
                                    'slug'                    => $slag,
                                    'serial_number'           => '0',
                                     );
                $this->atommodel->add_slug($data6);
                
                

    }
}


