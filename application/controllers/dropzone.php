<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dropzone extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->model('atommodel');
    }

    public function index() {
        $this->load->view('dropzone_view');
    }
    
    public function add_subject(){
        //$series_no= $this->input->post('series');
        $series_no=391;
        //$this->insert_subject($series_no);
        $series_id= $this->input->post('series');
        $items_id= $this->input->post('items');
        
        $this->data['validate']=1;
        $this->data['series_id']=$series_id;
        $this->data['items_id']=$items_id;
        $this->data['series']=$this->atommodel->get_series();
        $this->data['items']=$this->atommodel->get_subjects();
        $this->load->view('atom_home',$this->data);
    }

    function get_itemList($series){
//$series=391;
        echo json_encode($this->atommodel->get_subjects($series));
        //return $data;
        //var_dump($data);
        
    }

    public function upload() {
   
 //DroZone Code
                if (!empty($_FILES)) {
                $folderName='folder'; 
                $tempFile = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                
                 $series_no= $this->input->post('series1');
                //class_name=QubitDigitalObject / created_at='2015-05-19 00:06:12' / updated_at=dateTime / serial_number=0
                //Insert into object table                

                //Create folders
                $date ='folder';
                $tt='doc1';
                $str = hash( "sha256", $tempFile );
                $folder1='r';
                $folder2='null';
                $folder3=substr($str,0,1);
                $folder4=substr($str,1,1);
                $folder5=substr($str,2,1);
                
                //create folders

                if (!is_dir('uploads/'. $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str)) {
                    mkdir('./uploads/' . $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str, 0777, TRUE);

                }
                $targetPath = getcwd() . '/uploads/'. $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str.'/';
                $folderPath= '/uploads/'. $folder1.'/'. $folder2.'/'.$folder3.'/'.$folder4.'/'.$folder5.'/'.$str.'/';
                $targetFile = $targetPath . $fileName ;
                
                move_uploaded_file($tempFile, $targetFile);
                copy('C:/wamp/www/newProject/uploads/r/null/3/f/3/3f3d875f203e85aef8921089e53d734afdec862babd2b39cc8c0e97f022d1364/download.png', 'C:/wamp/www/newProject/uploads/New folder/download.png');
                
                $series_no= $this->input->post('series1');
                $series_no2= $this->input->post('series2');// 	391
                
//Insert subject
                //$this->insert_subject($series_no);
//Insert Title of the image $str,$targetPath,$fileName                
                //$this->insert_title_of_image($str,$targetPath,$fileName, $series_no2,$folderPath);
                
                
                
                

                    }
                    

                }


    
    function insert_title_of_image($str,$targetPath,$fileName,$series_no2,$folderPath){

                $date = date('Y-m-d H:i:s');
                //insert title(object table)
                $k=0;

                                    $data = array(               
                                    'class_name'              => 'QubitInformationObject',
                                    'created_at'              => $date,
                                    'updated_at'              => $date,
                                    'serial_number'           => $k,
                                     );
                $parent_id=$this->atommodel->add_post($data);
 //insert subject(information_object)
                                                                //get the Identifier
                                                                $farray = explode("-", $fileName);
                                                                $dotarray = explode(".", end($farray));
                                                                $identifier=$dotarray[0];
                                                                
                                                                //get level_of_discription_id
                                                                $tt=$this->atommodel->level_of_discription_id();
                                                                $level_of_description_id=$tt['id'];
                                                                
                                                                //get parent_id(selected subject id)
                                                                //391
                                                                //should get it from the dropdown lis(information object tabel ID colum)
                                                                //$series_no2
                                                                
                                                                //get rgt for title
                                                                $rgtarray=$this->atommodel->get_rgt($series_no2);
                                                                $lft=['rgt'];
                                                                //$parent_rgt=$rgtarray[0]['rgt'];
                                                                $rgt=$lft+1;
                //update all the lgt values in information_objetct table
                //$this->atommodel->update_all_lft($parent_rgt);
                
                //update all the rgt values in information_objetct table
                $this->atommodel->update_all_rgt($lft);
              
                
                $data1 = array(               
                                    'id'                        => $parent_id,
                                    'identifier'                => $identifier,
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
                                    'title'                   =>  $title,
                                    'extent_and_medium'       => 'Unspecified',
                                    'id'                      => $parent_id,
                                    'culture'                 => 'en',
                                     );
                $this->atommodel->add_information_object_i18n($data2);
                                                                        //get the slug name for title
                                                                        $slagrray = explode(".", $fileName);
                                                                        $slagtitle=$slagrray[0];
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
                                                                $slag=$sarray[0].'-'.end($sarray);
                $data6 = array(               
                                    'object_id'               => $parent_image_id,
                                    'slug'                    => $slag,
                                    'serial_number'           => '0',
                                     );
                $this->atommodel->add_slug($data6);
                
                

    }
    
    function insert_digital_object($parent_id){
                        //insert image to object as a new row
                 
    }
    

}
/* End of file dropzone.js */
/* Location: ./application/controllers/dropzone.php */
//- See more at: https://arjunphp.com/drag-drop-file-upload-dropzone-js-codeigniter/#sthash.lk332PQn.dpuf

