<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_start();

class Dashboard extends CI_Controller {

    public $xauth;
    public $show_name;
    public $IDs;

    public function __construct(){
        parent::__construct();

        $this->load->helper(array('form', 'url', 'html', 'directory', 'cookie'));
        $this->load->library(array('form_validation', 'security', 'pagination', 'session', 'nativesession'));
            //$this->load->library('email', $config);
            //$this->load->library('Ajax_pagination');
        $this->perPage = 20;
            //$this->perPage = 2;
            //$this->form_validation->set_error_delimeters('<div class="error">', '</div>');
        $this->form_validation->set_message('valid_email', 'Invalid email entered');
        $this->form_validation->set_message('alpha_space', 'Invalid name entered');
        $this->form_validation->set_message('max_length', 'name is too long, cant\'t proceed!');
        $this->form_validation->set_message('regex_match[/^[0-9]{6,11}$/]', 'Phone must contain numbers and a maximum of 11 digits!');
        $this->load->model('sql_models');
        @date_default_timezone_set('Africa/Lagos');

            // $merID = $this->sql_models->getMerID();
            // $cusID = $this->sql_models->getCusID();

            // $user_types1 = $this->input->cookie('user_types', TRUE);

            // if($user_types1 == "for_customer")
            //     $this->IDs = $cusID;
            // else
            //     $this->IDs = $merID;

            //$this->investorID = $merID;
            //$this->businesID = $cusID;
            //echo $this->IDs."mmmm";

            //echo $this->input->cookie('store_customer_usrs', TRUE)."<br>";
            //echo $this->input->cookie('store_customer_pas1', TRUE);



        function convertTime($difference){
                //Calculate how many days are within $difference
            $days = intval($difference / 86400); 
                //$days = round($difference / 86400); 
                //Keep the remainder
            $difference = $difference % 86400;
                //Calculate how many hours are within $difference 
            $hours = intval($difference / 3600)+($days*24); 
                //Keep the remainder
            $difference = $difference % 3600;
                //Calculate how many minutes are within $difference 
            $minutes = intval($difference / 60); 
                //Keep the remainder
            $difference = $difference % 60;
                //Calculate how many seconds are within $difference 
            $seconds = intval($difference); 
                //return "Days: ".$days."<br> Hours: ".$hours."<br> Minutes: ".$minutes."<br> Seconds: ".$seconds."<br>";
                //return $hours." hours, ".$minutes." mins more";
            return ($days);
        }


    }


       // Show view Page
        // public function index(){
        //     //echo $user_types = $this->input->cookie('user_types', TRUE);
        //     //echo $cookie_type = $this->input->cookie('user_types', TRUE);
        //     $user_types = $this->input->cookie('user_types', TRUE);
        //     if($this->sql_models->show_my_name()){
        //         if($user_types == "for_merchant"){
        //             $data['show_name'] = $this->sql_models->show_my_name();
        //             $data['page_name'] = "";
        //             $data['page_title'] = "Dashboard";
        //             if($user_types == "for_merchant"){
        //                 $data['easer_type'] = "Your Dashboard";
        //                 $ttype = "merchant";
        //             }else{
        //                 $data['easer_type'] = "Customer";
        //                 $ttype = "customer";
        //             }

        //             $data['allcount'] = $this->sql_models->cartCount(sha1($this->IDs), $user_types);
        //             $data['my_products'] = $this->sql_models->prodCounts(sha1($this->IDs));
        //             $data['total_items'] = $this->sql_models->totalItems();
        //             $data['total_members'] = $this->sql_models->totalMembers();
        //             $data['storeviews'] = $this->sql_models->storeViews(sha1($this->IDs));
        //             $data['amt_made'] = $this->sql_models->amountMade(sha1($this->IDs));
        //             $data['cart_details'] = $this->sql_models->cartList(sha1($this->IDs));
        //             $data['uploaded_prodts'] = $this->sql_models->uploadedProducts(sha1($this->IDs));
        //             $data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types);

        //             $this->load->view("dashboards1/header", $data);
        //             $this->load->view("dashboards1/index", $data);
        //         }else{
        //             redirect('dashboard/carts');

        //         }
        //     }else{
        //         redirect('node/login');
        //     }
        // }



    


    public function get_graph_data(){
        $get_id = $this->sql_models->getID1();
            //$this->db->select('inv_amt.investor_gain, inv_amt.amt, inv_amt.dates')->from('invested_amounts inv_amt');
        $this->db->select('inv_amt.investor_gain, inv_amt.amt')->from('invested_amounts inv_amt');
        $this->db->join('invoices inv', 'inv.id = inv_amt.invest_id');
        $this->db->where('sha1(inv_amt.memid)', $get_id)->where('inv.approved', 1);
            //$this->db->order_by('inv_amt.dates');
        $this->db->order_by('inv_amt.investor_gain');
        $query = $this->db->get();
        $amts = 0;
        if ($query->num_rows() > 0) {
            $query1 = $query->result_array();
            
                //loop through the returned data
            $data = array();
            foreach ($query1 as $row) {
                $data[] = $row;
            }
            echo json_encode($data);
            
            //}else{
                //return false;
        }
    }




    public function profile(){
        if($this->sql_models->show_my_name()){
            $data['page_name'] = "profile";
            $data['page_title'] = "Your Profile";
            $user_types = $this->input->cookie('user_types', TRUE);
            $data['user_types'] = $user_types;
            if($user_types == "for_customer")
                $data['easer_type'] = 'Your';
            else
                $data['easer_type'] = "Investor";
            $data['show_name'] = $this->sql_models->show_my_name();
            $data['profile_details'] = $this->sql_models->fetchProfile(sha1($this->IDs), $user_types);
            $data['get_logs'] = $this->sql_models->getLogs(sha1($this->IDs), $user_types);
            $data['log_count'] = $this->sql_models->getLogsCount(sha1($this->IDs), $user_types);
                //print_r($data);
            $this->load->view("dashboards1/header", $data);
            $this->load->view("dashboards1/index", $data);
                //$this->load->view("adminx1/footer");
        }else{
           redirect('node/login/');
       }
   }



   public function upload_pics_profile(){    
    $this->form_validation->set_rules('txtfnames', 'Full Names', 'required|trim|alpha_space');
    $this->form_validation->set_rules('txttel', 'Phone', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
    $this->form_validation->set_rules('txtemails', 'Email', 'required|trim|valid_email');

    $txtfnames = $this->input->post('txtfnames');
    $txttel = $this->input->post('txttel');
    $txtemails = $this->input->post('txtemails');
    $former_img = $this->input->post('files1');
    $txt_yes_file = $this->input->post('txt_yes_file');

    $path = $_FILES['files1']['name'];
    $type = explode('.', $_FILES["files1"]["name"]);
    $type = $type[count($type)-1];
    $randm = rand();
    $rename_file = $randm.$path;

            //$url = $_SERVER['DOCUMENT_ROOT']."/ider/application/views/profile_pics/".$rename_file; // does not work
            //$url = $_SERVER['DOCUMENT_ROOT']."/profile_pics/".$rename_file; // does not work
    $url = "profile_pics/".$rename_file;
            //base_url()."profile_pics/";
    $new_name1 = $rename_file;
    $file_tmp = $_FILES["files1"]["tmp_name"];
    $user_types = $this->input->cookie('user_types', TRUE);

    if($_FILES['files1']['name']!=''){
        if(is_uploaded_file($file_tmp)){
            $this->sql_models->delete_prof_pics(sha1($this->IDs), $user_types);
            move_uploaded_file($file_tmp, $url);
        }
        $data = array('names' => $txtfnames, 'emails' => $txtemails, 'phones' => $txttel, 'pics' => $rename_file);
                $empty_img = 0; // no, image is not empty
            }else{
                $data = array('names' => $txtfnames, 'emails' => $txtemails, 'phones' => $txttel);
                $empty_img = 1; // yes, image is empty
            }

                //if($txtinv_id != ""){
                    //$this->sql_models->deleteEachFile($txtinv_id, 'company_profile');
                    //$newdata3 = array(
                        //'company_profile'   => $new_name1
                    //);
                    //$this->sql_models->data_update_insert_invoice($newdata3, $rand_nos, '', '', $txtinv_id, $user_types1, $this->IDs);
                //}

            $data = $this->security->xss_clean($data);
            $uploads1 = $this->sql_models->update_my_profile($data, $this->IDs, $former_img, $empty_img, $user_types);
            if($uploads1){
                echo "success_profiles";
            }else{
                echo "Failed";
            }

            

        }


        
        function display_states(){
            //echo '<option value="" selected>Searching...</option>';
            $country_id = $this->input->post('country_id');
            $this->db->select('*')->from('states')->where('country_id', $country_id);
            $this->db->order_by('name', 'asc');
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $fetch_data = $query->result_array();
                echo '<option value="" selected>-Select State-</option>';
                foreach($fetch_data as $row)
                {
                    $ids1 = $row['id'];
                    $states = ucwords($row['name']);
                    echo "<option value='$ids1' states='$states'>$states</option>";
                }
            }else{
                echo "";
            }
            //sleep(2);
        }



        function display_cities(){
            $state_id = $this->input->post('state_id');
            $this->db->select('*')->from('cities')->where('state_id', $state_id);
            $this->db->order_by('name', 'asc');
            $query = $this->db->get();

            if($query->num_rows() > 0){
                $fetch_data = $query->result_array();
                echo '<option value="" selected>Select City</option>';
                foreach($fetch_data as $row)
                {
                    $ids1 = $row['id'];
                    $cities = ucwords($row['name']);
                    echo "<option value='$ids1' citys='$cities'>$cities</option>";
                }
            }else{
                echo "";
            }
            //sleep(2);
        }



        // function display_sub_cats(){
        //     $main_cat = $this->input->post('main_cat');
        //     $this->db->select('*')->from('sub_cats')->where('cid', $main_cat);
        //     $this->db->order_by('cat_name', 'asc');
        //     $query = $this->db->get();

        //     if($query->num_rows() > 0){
        //         $fetch_data = $query->result_array();
        //         foreach($fetch_data as $row)
        //         {
        //             $ids1 = $row['id'];
        //             $cates = ucwords($row['cat_name']);
        //             echo "<option value='$ids1'>$cates</option>";
        //         }

        //     }else{
        //         echo 0;
        //     }
        // }




        function upload_product1(){    
            $this->form_validation->set_rules('txtct1', 'category', 'required|trim');
            $this->form_validation->set_rules('txtct2', 'sub category', 'required|trim');
            $this->form_validation->set_rules('txtproducts', 'product name', 'required|trim');
            $this->form_validation->set_rules('txtqty', 'quantity', 'required|trim|numeric');
            $this->form_validation->set_rules('txtdesc', 'product description', 'trim');
            $this->form_validation->set_rules('txtprice', 'price', 'required|trim|numeric');
            $this->form_validation->set_rules('txtdiscount', 'discount', 'trim|numeric');
            $this->form_validation->set_rules('txtcolor_hid', 'color', 'trim');
            $this->form_validation->set_rules('txtsize_hid', 'size', 'trim');
            

            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{
                $txtid1 = $this->input->post('txtid1'); // id of a product if updating...
                $txtct1 = $this->input->post('txtct1');
                $txtct2 = $this->input->post('txtct2');
                $txtproducts = $this->input->post('txtproducts');
                $txtqty = $this->input->post('txtqty');
                $txtdesc = $this->input->post('txtdesc');
                $txtprice = $this->input->post('txtprice');
                $txtdiscount = $this->input->post('txtdiscount');
                $txtcolor = $this->input->post('txtcolor_hid');
                if($txtid1 == "")
                    $txtcolor = substr($txtcolor, 2);
                $txtsize = $this->input->post('txtsize_hid');
                $ad_logo_check1_prod = $this->input->post('ad_logo_check1_prod');
                $prod_pix = $this->input->post('prod_pix');
                if($txtid1 == "")
                    $txtsize = substr($txtsize, 2);

                $path = $_FILES['file']['name'];
                $type = explode('.', $_FILES["file"]["name"]);
                $type = $type[count($type)-1];
                $randm = rand();
                $rename_file = $randm.$path;
                
                $url = "products/".$rename_file;
                $new_name1 = $rename_file;
                $file_tmp = $_FILES["file"]["tmp_name"];
                $mer_id = $this->sql_models->getID1();

                if($_FILES['file']['name'] != '' || $txtid1 != ""){
                //if($_FILES['file']['name'] != '' || ($ad_logo_check1_prod > 0 && $prod_pix != "")){
                //if($_FILES['file']['name']!=''){
                    if(is_uploaded_file($file_tmp)){
                        $this->sql_models->delete_product_pix($prod_pix);
                        move_uploaded_file($file_tmp, $url);

                        $data = array(
                            'memid'     => $mer_id, 
                            'cats'      => $txtct1, 
                            'subcat'    => $txtct2,
                            'imgs'      => $rename_file,
                            'prod_name' => $txtproducts,
                            'qty'       => $txtqty,
                            'descrip'   => $txtdesc,
                            'price'     => $txtprice,
                            'discount'  => $txtdiscount,
                            'colors'    => $txtcolor,
                            'sizes'    => $txtsize,
                            'date_reg'  => @date("Y-m-d g:i a", time())
                        );

                    }else{

                        $data = array(
                            'memid'     => $mer_id, 
                            'cats'      => $txtct1, 
                            'subcat'    => $txtct2,
                            'prod_name' => $txtproducts,
                            'qty'       => $txtqty,
                            'descrip'   => $txtdesc,
                            'price'     => $txtprice,
                            'discount'  => $txtdiscount,
                            'colors'    => $txtcolor,
                            'sizes'     => $txtsize,
                            'date_reg'  => @date("Y-m-d g:i a", time())
                        );
                    }

                    $data = $this->security->xss_clean($data);
                    $uploads1 = $this->sql_models->add_products($data, $txtid1);
                    if($uploads1){
                        echo "success_uploads";
                    }else{
                        echo "Failed";
                    }
                }else{
                    echo "<p>All products require an image!</p>";
                }
            }
        }



        function update_noti_setn(){    
            $txtorders = $this->input->post('txtorders');
            $txtapproved = $this->input->post('txtapproved');
            $txtview = $this->input->post('txtview');
            $mer_id = $this->sql_models->getID1();
            $data = array(
                'memid'         => $mer_id, 
                'new_orders'    => $txtorders, 
                'app_products'  => $txtapproved,
                'view_num'      => $txtview
            );
            $data = $this->security->xss_clean($data);
            $uploads1 = $this->sql_models->update_setns($data, $mer_id);
            if($uploads1){
                echo "success_setns";
            }else{
                echo "Failed";
            }
        }



        public function uploadproducts(){
            if($this->sql_models->show_my_name()){
                $data['show_name'] = $this->sql_models->show_my_name();
                $data['page_name'] = "upload_products";
                $data['page_title'] = "Upload Your Products";
                $user_types = $this->input->cookie('user_types', TRUE);
                $data['user_types'] = $user_types;
                if($user_types == "for_customer")
                    $data['easer_type'] = $data['show_name'];
                else
                    $data['easer_type'] = "Investor";
                
                $data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types);
                $prods_id = $this->uri->segment(3);
                //echo $prods_id;
                $data['getcats'] = $this->sql_models->getCats();
                //$data['getsubcats'] = $this->sql_models->getSubCats();
                $data['getsetns'] = $this->sql_models->getNotiSetns();
                $data['getId'] = $this->sql_models->get_productID($prods_id);
                // $data['amounts_invested'] = $this->sql_models->get_investors_amts(sha1($this->IDs), 'cur', '');
                // $data['interest_made'] = $this->sql_models->getInterestMade(sha1($this->IDs), 'cur');
                // $data['get_logs'] = $this->sql_models->getLogs(sha1($this->IDs), $user_types);
                // $data['log_count'] = $this->sql_models->getLogsCount(sha1($this->IDs), $user_types);
                
                $this->load->view("dashboards1/header", $data);
                $this->load->view("dashboards1/index", $data);
            }else{
                redirect('node/login');
            }
        }



        



        public function current_campaign(){
            if($this->sql_models->show_my_name()){
                $data['show_name'] = $this->sql_models->show_my_name();
                $data['page_name'] = "current_campaign";
                $data['page_title'] = "Current Campaign";
                $user_types = $this->input->cookie('user_types', TRUE);
                $data['user_types'] = $user_types;
                
                if($user_types == "for_customer")
                    $data['easer_type'] = "Your";
                else
                    $data['easer_type'] = "Investor";
                
                $data['profile_details'] = $this->sql_models->fetchProfile(sha1($this->IDs), $user_types);
                $data['cur_invest'] = $this->sql_models->getCurrentInvestment(sha1($this->IDs), $user_types);
                $data['amounts_invested'] = $this->sql_models->get_investors_amts(sha1($this->IDs), 'cur', '');
                $data['interest_made'] = $this->sql_models->getInterestMade(sha1($this->IDs), 'cur');
                $data['get_logs'] = $this->sql_models->getLogs(sha1($this->IDs), $user_types);
                $data['log_count'] = $this->sql_models->getLogsCount(sha1($this->IDs), $user_types);
                $this->load->view("dashboards1/header", $data);
                $this->load->view("dashboards1/index", $data);
            }else{
                redirect('node/login');
            }
        }



        public function close_campaign(){
            if($this->sql_models->show_my_name()){
                $data['show_name'] = $this->sql_models->show_my_name();
                $data['page_name'] = "close_campaign";
                $data['page_title'] = "Closed Campaign";
                $user_types = $this->input->cookie('user_types', TRUE);
                $data['user_types'] = $user_types;
                
                if($user_types == "for_customer")
                    $data['easer_type'] = "Your";
                else
                    $data['easer_type'] = "Investor";
                
                $data['profile_details'] = $this->sql_models->fetchProfile(sha1($this->IDs), $user_types);
                //$data['cur_invest'] = $this->sql_models->getCurrentInvestment(sha1($this->IDs), $user_types);
                $data['amounts_invested'] = $this->sql_models->get_investors_amts(sha1($this->IDs), 'pst', '');
                $data['get_logs'] = $this->sql_models->getLogs(sha1($this->IDs), $user_types);
                $data['log_count'] = $this->sql_models->getLogsCount(sha1($this->IDs), $user_types);
                
                $this->load->view("dashboards1/header", $data);
                $this->load->view("dashboards1/index", $data);
            }else{
                redirect('node/login');
            }
        }




        public function past_investments(){
            if($this->sql_models->show_my_name()){
                $data['show_name'] = $this->sql_models->show_my_name();
                $data['page_name'] = "past_investment";
                $data['page_title'] = "Closed Campaigns <font style='font-size:15px; color:#999;'>(Past Investments)</font>";
                $user_types = $this->input->cookie('user_types', TRUE);
                $data['user_types'] = $this->input->cookie('user_types', TRUE);
                if($user_types == "for_customer")
                    $data['easer_type'] = $data['show_name'];
                else
                    $data['easer_type'] = "Investor";
                
                //$data['pst_invest'] = $this->sql_models->getPastInvestment_full(sha1($this->IDs));
                $data['profile_details'] = $this->sql_models->fetchProfile(sha1($this->IDs), $user_types);
                $data['amounts_invested'] = $this->sql_models->get_investors_amts(sha1($this->IDs), 'pst', '');
                $data['interest_made'] = $this->sql_models->getInterestMade(sha1($this->IDs), 'pst');
                $data['get_logs'] = $this->sql_models->getLogs(sha1($this->IDs), $user_types);
                $data['log_count'] = $this->sql_models->getLogsCount(sha1($this->IDs), $user_types);

                $this->load->view("dashboards1/header", $data);
                $this->load->view("dashboards1/index", $data);
            }else{
                redirect('node/login');
            }
        }




        // public function products(){
        //     $user_types = $this->input->cookie('user_types', TRUE);
        //     $data['user_types'] = $this->input->cookie('user_types', TRUE);
        //     $data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types);
        //     if($this->sql_models->show_my_name()){
        //         if($user_types == "for_merchant"){
        //             $data['show_name'] = $this->sql_models->show_my_name();
        //             $data['page_name'] = "products";
        //             $data['page_title'] = "View & Edit Your Products";
        //             $data['easer_type'] = "";
        //             $this->load->view("dashboards1/header", $data);
        //             $this->load->view("dashboards1/index", $data);
        //         }else{
        //             redirect('');
        //         }
        //     }else{
        //         redirect('node/login');
        //     }
        // }



        // public function carts(){
        //     $user_types = $this->input->cookie('user_types', TRUE);
        //     $data['user_types'] = $this->input->cookie('user_types', TRUE);
        //     $data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types);
        //     if($this->sql_models->show_my_name()){
        //         //if($user_types == "for_merchant"){
        //         $data['show_name'] = $this->sql_models->show_my_name();
        //         $data['page_name'] = "carts";
        //         $data['page_title'] = " Your Carts";
        //         $data['easer_type'] = "";
        //         $this->load->view("dashboards1/header", $data);
        //         $this->load->view("dashboards1/index", $data);
        //         // }else{
        //         //     redirect('');
        //         // }
        //     }else{
        //         redirect('node/login');
        //     }
        // }



        public function your_customers(){
            $user_types = $this->input->cookie('user_types', TRUE);
            $data['user_types'] = $this->input->cookie('user_types', TRUE);
            $data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types);
            if($this->sql_models->show_my_name()){
                if($user_types == "for_merchant"){
                    $data['show_name'] = $this->sql_models->show_my_name();
                    $data['page_name'] = "your_customers";
                    $data['page_title'] = " Your Customers";
                    $data['easer_type'] = "";
                    $this->load->view("dashboards1/header", $data);
                    $this->load->view("dashboards1/index", $data);
                }else{
                    redirect('');
                }
            }else{
                redirect('node/login');
            }
        }


        public function settings(){
            $user_types = $this->input->cookie('user_types', TRUE);
            $data['user_types'] = $this->input->cookie('user_types', TRUE);
            if($this->sql_models->show_my_name()){
                //if($user_types == "for_merchant"){
                $data['show_name'] = $this->sql_models->show_my_name();
                $data['fetchDetails'] = $this->sql_models->fetchDetails(sha1($this->IDs), $user_types);
                $data['profile_details'] = $this->sql_models->fetchProfile(sha1($this->IDs), $user_types);
                $data['page_name'] = "settings";
                $data['page_title'] = " Settings";
                $data['easer_type'] = "";
                $this->load->view("dashboards1/header", $data);
                $this->load->view("dashboards1/index", $data);
                // }else{
                //     redirect('');
                // }
            }else{
                redirect('node/login');
            }
        }



        public function upload_profile_pix(){
            $this->form_validation->set_rules('txtfname', 'first name', 'required|trim|alpha_space');
            $this->form_validation->set_rules('txtlname', 'last name', 'required|trim|alpha_space');
            $this->form_validation->set_rules('phone1', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
            $this->form_validation->set_rules('email1', 'email', 'required|trim|valid_email');
            $this->form_validation->set_rules('txtcountry', 'country', 'trim');
            $this->form_validation->set_rules('txtstates1_', 'state', 'trim');
            $this->form_validation->set_rules('txtcitys', 'city/region', 'required|trim');
            $this->form_validation->set_rules('txtaddr', 'address/location', 'required|trim');
            $txtmerchantID = $this->input->post('txtmerchantID');
            $txtf0 = $this->input->post('txtf0');
            
            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{

                $txtcountry = $this->input->post('txtcountry');
                $txtstates1_ = $this->input->post('txtstates1_');
                $txtcitys = $this->input->post('txtcitys');

                $txtcountry = $this->sql_models->getContryByName($txtcountry);
                $txtstates1_ = $this->sql_models->getStateByName($txtstates1_);
                $txtcitys = $this->sql_models->getCityByName($txtcitys);

                $path4 = $_FILES['txtlogo_up']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');

                if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['txtlogo_up']['name']) && $_FILES['txtlogo_up']['name'] != "")
                    echo "Please select a valid image for company's logo<br>";
                else if(isset($_FILES['txtlogo_up']['name']) && $_FILES['txtlogo_up']['size'] > 512000)
                    echo "The company's logo file has exceeded 500kb<br>";
                else{
                    $type = explode('.', $_FILES["txtlogo_up"]["name"]);
                    $type = $type[count($type)-1];
                    $randm = rand();
                    $rename_file = $randm.$path4;

                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "profile_pics/".$rename_file;
                    //$url = "profile_pics/".$rename_file;

                    $new_name4 = $rename_file;
                    if(isset($_FILES['txtlogo_up']['name']) && $_FILES['txtlogo_up']['name'] != ''){
                        $file_tmp = $_FILES["txtlogo_up"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['txtlogo_up']['name']) ){
                            $this->sql_models->delete_files($txtf0);
                        move_uploaded_file($file_tmp, $url);
                        $d = compress($url_source, $url_dest, 35);

                        }
                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        $newdata3 = array(
                            'fname'              => $this->input->post('txtfname'),
                            'lname'              => $this->input->post('txtlname'),
                            'emails'             => $this->input->post('email1'),
                            'phones'             => $this->input->post('phone1'),
                            'addrs'               => $this->input->post('txtaddr'),
                            'citys'              => $txtcitys,
                            'states'             => $txtstates1_,
                            'countrys'           => $txtcountry,
                            'pics'               => $new_name4
                        );
                    }else{ // image not set
                        $newdata3 = array(
                            'fname'              => $this->input->post('txtfname'),
                            'lname'              => $this->input->post('txtlname'),
                            'emails'             => $this->input->post('email1'),
                            'phones'             => $this->input->post('phone1'),
                            'addrs'               => $this->input->post('txtaddr'),
                            'citys'              => $txtcitys,
                            'states'             => $txtstates1_,
                            'countrys'           => $txtcountry
                        );
                    }

                    $newdata3 = $this->security->xss_clean($newdata3);
                    $querys1 = $this->sql_models->update_insert_customer($newdata3, '', '', $txtmerchantID);
                    echo "dones1";
                }            
            }
        }



        public function upload_adm_vd(){
            function compress($source, $destination, $quality) {
                $info = getimagesize($source);
                if ($info['mime'] == 'image/jpeg') 
                    $image = imagecreatefromjpeg($source);
                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($source);
                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($source);
                imagejpeg($image, $destination, $quality);
                return $destination;
            }
            $this->form_validation->set_rules('txtvidtitle', 'title of Ad', 'required|trim|alpha_space');
            $txtf0 = $this->input->post('txtv1');
            $txtf1 = $this->input->post('txtvf1');
            $txtedit = $this->input->post('txtedit');
            
            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{

                $txtvidtitle = $this->input->post('txtvidtitle');
                
                $path3 = $_FILES['file_vid']['name'];
                $ext3 = pathinfo($path3, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('mp4');

                $path4 = $_FILES['file_pics']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk2 = array('jpg','png','jpeg');

                if($_FILES['file_vid']['name'] == "" && $txtf0=="")
                    echo "Please select a video file<br>";
                else if(!in_array($ext3,$img_ext_chk1) && isset($_FILES['file_vid']['name']) && $_FILES['file_vid']['name'] != "")
                    echo "Please select a valid video file of format mp4<br>";
                else if(isset($_FILES['file_vid']['name']) && $_FILES['file_vid']['size'] > 4194304)
                    echo "The video file has exceeded 4MB<br>";

                else if($_FILES['file_pics']['name'] == "" && $txtf1=="")
                    echo "Please select an image cover file<br>";
                else if(!in_array($ext4,$img_ext_chk2) && isset($_FILES['file_pics']['name']) && $_FILES['file_pics']['name'] != "")
                    echo "Please select a valid cover image for the video of format jpg, png.<br>";
                else if(isset($_FILES['file_pics']['name']) && $_FILES['file_pics']['size'] > 1048576)
                    echo "The image file has exceeded 1MB<br>";

                else{
                    $type = explode('.', $_FILES["file_vid"]["name"]);
                    $type = $type[count($type)-1];
                    $randm = rand();
                    $rename_file = $randm.$path3;

                    $type2 = explode('.', $_FILES["file_pics"]["name"]);
                    $type2 = $type2[count($type2)-1];
                    $randm2 = rand();
                    $rename_file2 = $randm2.$path4;

                    $rename_file = str_replace(" ", "_", $rename_file);
                    $rename_file2 = str_replace(" ", "_", $rename_file2);

                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "admin_vids/".$rename_file;
                    
                    $url_source1 = "fake_fols/".$rename_file2;
                    $url_dest1 = "admin_vids/".$rename_file2;

                    $new_name3 = $rename_file;
                    $new_name4 = $rename_file2;

                    if($ext3!="" && $ext4==""){
                        $file_tmp = $_FILES["file_vid"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file_vid']['name']) ){
                            $this->sql_models->delete_files($txtf0);
                            move_uploaded_file($file_tmp, $url_dest);
                        }
                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        if($txtedit!=""){
                            $newdata3 = array(
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'files'              => $new_name3
                            );
                        }else{
                            $newdata3 = array(
                                'activates'          => 0,
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'files'              => $new_name3,
                                'views'              => 0
                            );
                        }
                    
                    }else if($ext3=="" && $ext4!=""){
                        $file_tmp = $_FILES["file_pics"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file_pics']['name']) ){
                            if($txtedit!="")
                                $this->sql_models->delete_files($txtf1);
                            move_uploaded_file($file_tmp, $url_source1);
                            $d = compress($url_source1, $url_dest1, 55);
                        }
                        $in_folder1="fake_fols/".$rename_file2;
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        if($txtedit!=""){
                            $newdata3 = array(
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'pics'               => $new_name4
                            );
                        }else{
                            $newdata3 = array(
                                'activates'          => 0,
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'pics'               => $new_name4,
                                'views'              => 0
                            );
                        }

                    }else if($ext3!="" && $ext4!=""){
                        $file_tmp = $_FILES["file_vid"]["tmp_name"];
                        $file_tmp2 = $_FILES["file_pics"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['file_vid']['name']) ){
                            if($txtedit!="")
                                $this->sql_models->delete_files($txtf0);
                            move_uploaded_file($file_tmp, $url_dest);
                        }

                        if(is_uploaded_file($file_tmp2) && isset($_FILES['file_pics']['name']) ){
                            if($txtedit!="")
                                $this->sql_models->delete_files($txtf1);
                            move_uploaded_file($file_tmp2, $url_source1);
                            $d = compress($url_source1, $url_dest1, 55);
                        }
                        $in_folder1="fake_fols/".$rename_file2;
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        if($txtedit!=""){
                            $newdata3 = array(
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'pics'               => $new_name4,
                                'files'              => $new_name3
                            );
                        }else{
                            $newdata3 = array(
                                'activates'          => 0,
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'pics'               => $new_name4,
                                'files'              => $new_name3,
                                'views'              => 0
                            );
                        }

                    }else{ // image not set
                        if($txtedit!=""){
                            $newdata3 = array(
                                'vid_title'          => $this->input->post('txtvidtitle')
                            );
                        }else{
                            $newdata3 = array(
                                'activates'          => 0,
                                'vid_title'          => $this->input->post('txtvidtitle'),
                                'pics'               => "",
                                'files'              => "",
                                'views'              => 0
                            );
                        }
                    }

                    $newdata3 = $this->security->xss_clean($newdata3);
                    $querys1 = $this->sql_models->update_inert_adm_vid($newdata3, $txtedit);
                    echo "dones3";
                }            
            }
        }




        public function upload_bma_profile_pix(){

            function compress($source, $destination, $quality) {
                $info = getimagesize($source);
                if ($info['mime'] == 'image/jpeg') 
                    $image = imagecreatefromjpeg($source);
                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($source);
                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($source);
                imagejpeg($image, $destination, $quality);
                return $destination;
            }


            $txtmember = $this->input->post('txtmember');
            $this->form_validation->set_rules('txtfname', 'first name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
            $this->form_validation->set_rules('txtlname', 'last name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
            $this->form_validation->set_rules('phone1', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
            $this->form_validation->set_rules('email1', 'email', 'required|trim|valid_email');
            $txtbm_type = $this->input->post('txtbm_type');

            if($txtmember==""){
                $this->form_validation->set_rules('txtpass1', 'password', 'required|trim|matches[txtpass2]');
                $this->form_validation->set_rules('txtpass2', 'confirm password', 'required|trim');
            }

            if($txtmember!=""){
                $this->form_validation->set_rules('txtcountry', 'country', 'required|trim');
                $this->form_validation->set_rules('txtstates1_', 'state', 'required|trim');
                $this->form_validation->set_rules('txtcitys', 'city/region', 'required|trim');
            }
            $txtf0 = $this->input->post('txtf0');

            $txt_yes_file_bma = $this->input->post('txt_yes_file_bma');
            $checkme = $this->input->post('checkme');
            $checkme1 = $this->input->post('checkme1');
            if($checkme=="on" || $checkme==1) $checkme=1; else $checkme=0;
            if($checkme1=="on" || $checkme1==1) $checkme1=1; else $checkme1=0;
            
            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{

                $txtcountry = $this->input->post('txtcountry');
                $txtstates1_ = $this->input->post('txtstates1_');
                $txtcitys = $this->input->post('txtcitys');
                
                $txtcountry = $this->sql_models->getContryByName($txtcountry);
                $txtstates1_ = $this->sql_models->getStateByName($txtstates1_);
                $txtcitys = $this->sql_models->getCityByName($txtcitys);
    
                $path4 = @$_FILES['txt_bma_pic']['name'];
                $ext4 = pathinfo($path4, PATHINFO_EXTENSION);
                $img_ext_chk1 = array('jpg','png','jpeg');


                if(@$_FILES['txt_bma_pic']['name'] == "" && $txt_yes_file_bma==0)
                    echo "Please upload your profile photo and continue<br>";
                else if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != "")
                    echo "Please select a valid image for profile photo<br>";
                else if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['size'] > 4194304)
                    echo "Your profile photo has exceeded 4MB<br>";
                else{
                    $type = explode('.', @$_FILES["txt_bma_pic"]["name"]);
                    $type = $type[count($type)-1];
                    $randm = rand();
                    $rename_file = $randm.$path4;
                    
                    $url_source = "fake_fols/".$rename_file;
                    $url_dest = "bma_profile_pics/".$rename_file;
                    
                    $new_name4 = $rename_file;
                    if(isset($_FILES['txt_bma_pic']['name']) && @$_FILES['txt_bma_pic']['name'] != ''){
                        $file_tmp = @$_FILES["txt_bma_pic"]["tmp_name"];
                        if(is_uploaded_file($file_tmp) && isset($_FILES['txt_bma_pic']['name']) ){
                            if($txtmember != "")
                                $this->sql_models->delete_bma_pics($txtf0);

                            move_uploaded_file($file_tmp, $url_source);
                            $d = compress($url_source, $url_dest, 35);
                        }

                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        if($txtmember==""){
                            $newdata3 = array(
                                'approved'           => 1,
                                'session1'           => time(),
                                'user_type'          => 'm',
                                'bm_type'            => $txtbm_type,
                                'fname'              => $this->input->post('txtfname'),
                                'lname'              => $this->input->post('txtlname'),
                                'emails'             => $this->input->post('email1'),
                                'email_visible'      => $checkme1,
                                'phones'             => $this->input->post('phone1'),
                                'phone_visible'      => $checkme,
                                'pass1'              => sha1($this->input->post('txtpass1')),
                                //'citys'              => $txtcitys,
                                //'states'             => $txtstates1_,
                                //'countrys'           => $txtcountry,
                                'picx'               => $new_name4,
                                'dates' => @date("Y-m-d g:i a", time())
                            );

                        }else{
                            $newdata3 = array(
                                //'user_type'          => 'm',
                                'bm_type'            => $txtbm_type,
                                'fname'              => $this->input->post('txtfname'),
                                'lname'              => $this->input->post('txtlname'),
                                'emails'             => $this->input->post('email1'),
                                'email_visible'      => $checkme1,
                                'phones'             => $this->input->post('phone1'),
                                'phone_visible'      => $checkme,
                                'citys'              => $txtcitys,
                                'states'             => $txtstates1_,
                                'countrys'           => $txtcountry,
                                'picx'               => $new_name4,
                                'gender'             => $this->input->post('txtsex'),
                                'work'               => $this->input->post('txtwork')
                            );

                        }
                    }else{ // image not set
                        if($txtmember==""){
                            $newdata3 = array(
                                'approved'           => 1,
                                'session1'           => time(),
                                'user_type'          => 'm',
                                'bm_type'            => $txtbm_type,
                                'fname'              => $this->input->post('txtfname'),
                                'lname'              => $this->input->post('txtlname'),
                                'emails'             => $this->input->post('email1'),
                                'email_visible'      => $checkme1,
                                'phones'             => $this->input->post('phone1'),
                                'phone_visible'      => $checkme,
                                'pass1'              => sha1($this->input->post('txtpass1')),
                                //'citys'              => $txtcitys,
                                //'states'             => $txtstates1_,
                                //'countrys'           => $txtcountry,
                                //'gender'             => $this->input->post('txtsex'),
                                'work'               => $this->input->post('txtwork'),
                                'dates' => @date("Y-m-d g:i a", time())
                            );

                        }else{
                            $newdata3 = array(
                                //'user_type'          => 'm',
                                'bm_type'            => $txtbm_type,
                                'fname'              => $this->input->post('txtfname'),
                                'lname'              => $this->input->post('txtlname'),
                                'emails'             => $this->input->post('email1'),
                                'email_visible'      => $checkme1,
                                'phones'             => $this->input->post('phone1'),
                                'phone_visible'      => $checkme,
                                'citys'              => $txtcitys,
                                'states'             => $txtstates1_,
                                'countrys'           => $txtcountry,
                                'gender'             => $this->input->post('txtsex'),
                                'work'               => $this->input->post('txtwork')
                                //'dates' => @date("Y-m-d g:i a", time())
                            );

                        }
                    }

                    $newdata3 = $this->security->xss_clean($newdata3);
                    if($txtmember==""){
                        $querys0 = $this->sql_models->check_bma_details($this->input->post('email1'), $this->input->post('phone1'));

                        if($querys0){
                            $querys1 = $this->sql_models->update_insert_bma_members($newdata3, $this->input->post('email1'), $this->input->post('phone1'), '');
                            //$this->nativesession->set('session1_id', time());
                            if(!$querys1)
                                echo "Error in network connection!";
                            else{
                                $now = 2147483647 - time();
                                
                                $cookie = array(
                                    'name'   => 'bma_customer_email',
                                    'value'  => sha1($this->input->post('email1')),
                                    'expire' => $now,
                                    'secure' => FALSE
                                );

                                $cookie1 = array(
                                    'name'   => 'bma_customer_pas1',
                                    'value'  => sha1($this->input->post('txtpass1')),
                                    'expire' => $now,
                                    'secure' => FALSE
                                );
                                set_cookie($cookie);
                                set_cookie($cookie1);

                                $emails_2 = $this->input->post('email1');
                                $phone1_2 = $this->input->post('phone1');
                                $txtpass1_2 = sha1($this->input->post('txtpass1'));
                                $this->db->select('session1')->from('bma_accounts')->where('emails', $emails_2)->where('phones', $phone1_2)->where('pass1', $txtpass1_2);
                                $query = $this->db->get();
                                $session1_ids = $query->row('session1');
                                
                                $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='https://bm.brandenvoy.mobi/img/bma_logo.png'></div>";
                                $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello there,</b></p>";
                                $message_contents .= "<p style='font-size:14px; margin-top:10px'>
                                Thank you for registering on BrandMarket, we hope you will enjoy all the benefits and free access to upload your Ads
                                to be seen by more people.<br><br>Please click on this link below or copy it and paste on your URL to activte your account.<br>
                                <b><a href='https://bm.brandenvoy.mobi/activate_account/$session1_ids' target='_blank'>https://bm.brandenvoy.mobi/activate_account/$session1_ids</a></b>
                                </p>";
                
                                $message_contents .= "<p style='font-size:14px; margin:10px 0 20px 0'>Thank you!</p>";
                                $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                                $message_contents .= "<a href='https://bm.brandenvoy.mobi' style='color:#0066FF' target='_blank'>bm.brandenvoy.mobi</a></p>";
                
                                $api_key= "2927c79e9f3e624977ac0d5b0c977504-c1fe131e-c11cad41";/* Api Key got from https://mailgun.com/cp/my_account */
                                $domain = "righturngroup.com";/* Domain Name you given to Mailgun */
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                                    'from' => "BrandMarket Account Activation <info@bm.brandenvoy.mobi>",
                                    'to' => $this->input->post('email1'),
                                    'subject' => "Please activate your account",
                                    'html' => $message_contents
                                ));
                                $result = curl_exec($ch);
                                curl_close($ch);
                                echo "done_2";
                            }
                        }else{
                            echo "Email or phone number already exists";
                        }
                    }else{ // update
                        $querys1 = $this->sql_models->update_insert_bma_members($newdata3, $this->input->post('email1'), $this->input->post('phone1'), $txtmember);
                        echo "done_2";
                    }
                }
                //}
            }
        }



        public function upload_bma_profile_pix_buyer(){
            $this->form_validation->set_rules('txtfname', 'first name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
            $this->form_validation->set_rules('txtlname', 'last name', 'required|trim|alpha_space|min_length[4]|max_length[15]');
            $this->form_validation->set_rules('phone1', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
            $this->form_validation->set_rules('email1', 'email', 'required|trim|valid_email');
            $txtbm_type = "b";
            $this->form_validation->set_rules('txtpass1', 'password', 'required|trim|matches[txtpass2]');
            $this->form_validation->set_rules('txtpass2', 'confirm password', 'required|trim');

            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{
                        
                $newdata3 = array(
                    'approved'           => 1,
                    'user_type'          => 'm',
                    'bm_type'            => $txtbm_type,
                    'fname'              => $this->input->post('txtfname'),
                    'lname'              => $this->input->post('txtlname'),
                    'emails'             => $this->input->post('email1'),
                    'phones'             => $this->input->post('phone1'),
                    'pass1'              => sha1($this->input->post('txtpass1')),
                    'dates'              => @date("Y-m-d g:i a", time())
                );

                $newdata3 = $this->security->xss_clean($newdata3);
                $querys0 = $this->sql_models->check_bma_details($this->input->post('email1'), $this->input->post('phone1'));

                if($querys0){
                    $querys1 = $this->sql_models->update_insert_bma_members($newdata3, $this->input->post('email1'), $this->input->post('phone1'), '');
                    //$querys1 = true;
                    if(!$querys1)
                        echo "Error in network connection!";
                    else{
                        $now = 2147483647 - time();
                        $cookie = array(
                            'name'   => 'bma_customer_email',
                            'value'  => sha1($this->input->post('email1')),
                            'expire' => $now,
                            'secure' => FALSE
                        );

                        $cookie1 = array(
                            'name'   => 'bma_customer_pas1',
                            'value'  => sha1($this->input->post('txtpass1')),
                            'expire' => $now,
                            'secure' => FALSE
                        );
                        set_cookie($cookie);
                        set_cookie($cookie1);
                        
                        $get_buyer_id = $this->sql_models->getBuyerID($this->input->post('email1'), sha1($this->input->post('txtpass1')));
                        if($get_buyer_id)
                            echo $get_buyer_id;
                        else
                            echo "Error!";
                    }
                }else{
                    echo "Email or phone number already exists";
                }
                
            }
        }



        public function upload_bma_profile_pix_ref(){

            function compress($source, $destination, $quality) {
                $info = getimagesize($source);
                if ($info['mime'] == 'image/jpeg') 
                    $image = imagecreatefromjpeg($source);
                elseif ($info['mime'] == 'image/gif') 
                    $image = imagecreatefromgif($source);
                elseif ($info['mime'] == 'image/png') 
                    $image = imagecreatefrompng($source);
                imagejpeg($image, $destination, $quality);
                return $destination;
            }

            $txtmember = $this->input->post('txtmember');
            $this->form_validation->set_rules('txtfnames', 'full names', 'required|trim|alpha_space|min_length[7]|max_length[15]');
            $this->form_validation->set_rules('phone1', 'phone number', 'required|trim|numeric|regex_match[/^[0-9]{6,11}$/]');
            $this->form_validation->set_rules('email1', 'email', 'required|trim|valid_email');

            if($txtmember==""){
                $this->form_validation->set_rules('txtpass1', 'password', 'required|trim|matches[txtpass2]');
                $this->form_validation->set_rules('txtpass2', 'confirm password', 'required|trim');
            }
            //$this->form_validation->set_rules('txtacctname', 'account name', 'required|trim|alpha_space|matches[txtfnames]');
            $this->form_validation->set_rules('txtbank', 'bank name', 'required');
            $this->form_validation->set_rules('txtacctno', 'account number', 'required|trim|numeric');

            $txtf0 = $this->input->post('txtf0');
            $txtf1 = $this->input->post('txtf1');
            $txt_yes_file_bma = $this->input->post('txt_yes_file_bma');
            $txt_yes_file_bma1 = $this->input->post('txt_yes_file_bma1');

            $txtacctname = $this->input->post('txtacctname');
            $txtfnames = $this->input->post('txtfnames');
            
            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{

                if(strtolower($txtacctname) != strtolower($txtfnames)){
                    echo "Your account name must match with your names!";
                }else{

                    $path4 = strtolower($_FILES['txt_bma_pic']['name']);
                    $ext4 = pathinfo($path4, PATHINFO_EXTENSION);

                    $path3 = strtolower($_FILES['txt_file']['name']);
                    $ext3 = pathinfo($path3, PATHINFO_EXTENSION);

                    $img_ext_chk1 = array('jpg','png','jpeg');
                    $img_ext_chk2 = array('jpg','png','jpeg', 'doc', 'xls', 'docx', 'ppt', 'pptx', 'pdf', 'txt');

                    $gen_num1=time();
                    $gen_num1=substr($gen_num1,7);

                    if($_FILES['txt_bma_pic']['name'] == "" && $txt_yes_file_bma==0)
                        echo "Please upload your profile photo and continue<br>";
                    else if(!in_array($ext4,$img_ext_chk1) && isset($_FILES['txt_bma_pic']['name']) && $_FILES['txt_bma_pic']['name'] != "")
                        echo "Please select a valid image for profile photo<br>";
                    else if(isset($_FILES['txt_bma_pic']['name']) && $_FILES['txt_bma_pic']['size'] > 4194304)
                        echo "Your profile photo has exceeded 4MB<br>";

                    else if($_FILES['txt_file']['name'] == "" && $txt_yes_file_bma1==0)
                        echo "Please upload your necessary document<br>";
                    else if(!in_array($ext3,$img_ext_chk2) && isset($_FILES['txt_file']['name']) && $_FILES['txt_file']['name'] != "")
                        echo "Please select a valid file<br>";
                    else if(isset($_FILES['txt_file']['name']) && $_FILES['txt_file']['size'] > 4194304)
                        echo "The file you selected has exceeded 4MB<br>";

                    else{
                        $type = explode('.', $_FILES["txt_bma_pic"]["name"]);
                        $type = $type[count($type)-1];
                        $randm = rand();
                        $rename_file = $randm.$path4;

                        $type1 = explode('.', $_FILES["txt_file"]["name"]);
                        $type1 = $type1[count($type1)-1];
                        $randm1 = rand();
                        $rename_file1 = $randm1.$path3;
                        
                        $url_source = "fake_fols/";
                        $url_dest = "bma_profile_pics/";

                        $rename_file = str_replace(" ", "_", $rename_file);
                        $rename_file1 = str_replace(" ", "_", $rename_file1);

                        $new_name4 = $rename_file;
                        $new_name5 = $rename_file1;
                        //if(isset($_FILES['txt_bma_pic']['name']) && $_FILES['txt_bma_pic']['name'] != ''){
                        $file_tmp = $_FILES["txt_bma_pic"]["tmp_name"];
                        $file_tmp1 = $_FILES["txt_file"]["tmp_name"];

                        if(is_uploaded_file($file_tmp) && isset($_FILES['txt_bma_pic']['name']) ){
                            if($txtmember != "")
                                $this->sql_models->delete_bma_pics($txtf0);
                            move_uploaded_file($file_tmp, $url_source.$rename_file);
                            $d = compress($url_source.$rename_file, $url_dest.$rename_file, 35);
                        }

                        if(is_uploaded_file($file_tmp1) && isset($_FILES['txt_file']['name']) ){
                            if($txtmember != "")
                                $this->sql_models->delete_bma_pics($txtf1);
                            if($ext3=="jpg" || $ext3=="png" || $ext3=="gif" || $ext3=="jpeg"){
                                move_uploaded_file($file_tmp1, $url_source.$rename_file1);
                                $d = compress($url_source.$rename_file1, $url_dest.$rename_file1, 35);
                            }else{
                                move_uploaded_file($file_tmp1, "bma_profile_pics/".$rename_file1);
                            }
                        }


                        if($txtmember==""){
                            $newdata3 = array(
                                'approved'           => 0,
                                'refs1'              => 1,
                                'ref_code'           => $gen_num1,
                                'fname'              => $this->input->post('txtfnames'),
                                'emails'             => $this->input->post('email1'),
                                'phones'             => $this->input->post('phone1'),
                                'pass1'              => sha1($this->input->post('txtpass1')),
                                'picx'               => $new_name4,
                                'ip_addrs'           => $this->input->ip_address(),
                                'acct_name'          => $this->input->post('txtacctname'),
                                'bank_name'          => $this->input->post('txtbank'),
                                'acct_no'            => $this->input->post('txtacctno'),
                                //'txt_files'          => $new_name5,
                                'dates'              => @date("Y-m-d g:i a", time())
                            );

                        }else{

                            if($ext4 != "" && $ext3 != ""){
                                $newdata3 = array(
                                    'approved'           => 0,
                                    'fname'              => $this->input->post('txtfnames'),
                                    'emails'             => $this->input->post('email1'),
                                    'phones'             => $this->input->post('phone1'),
                                    'picx'               => $new_name4,
                                    'ip_addrs'           => $this->input->ip_address(),
                                    'acct_name'          => $this->input->post('txtacctname'),
                                    'bank_name'          => $this->input->post('txtbank'),
                                    'acct_no'            => $this->input->post('txtacctno'),
                                    'txt_files'          => $new_name5
                                );
                            }else if($ext4 != "" && $ext3 == ""){
                                $newdata3 = array(
                                    'approved'           => 0,
                                    'fname'              => $this->input->post('txtfnames'),
                                    'emails'             => $this->input->post('email1'),
                                    'phones'             => $this->input->post('phone1'),
                                    'picx'               => $new_name4,
                                    'ip_addrs'           => $this->input->ip_address(),
                                    'acct_name'          => $this->input->post('txtacctname'),
                                    'bank_name'          => $this->input->post('txtbank'),
                                    'acct_no'            => $this->input->post('txtacctno')
                                );
                            
                            }else if($ext4 == "" && $ext3 != ""){
                                $newdata3 = array(
                                    'approved'           => 0,
                                    'fname'              => $this->input->post('txtfnames'),
                                    'emails'             => $this->input->post('email1'),
                                    'phones'             => $this->input->post('phone1'),
                                    'ip_addrs'           => $this->input->ip_address(),
                                    'acct_name'          => $this->input->post('txtacctname'),
                                    'bank_name'          => $this->input->post('txtbank'),
                                    'acct_no'            => $this->input->post('txtacctno'),
                                    'txt_files'          => $new_name5
                                );
                            }else{
                                $newdata3 = array(
                                    'approved'           => 0,
                                    'fname'              => $this->input->post('txtfnames'),
                                    'emails'             => $this->input->post('email1'),
                                    'phones'             => $this->input->post('phone1'),
                                    'ip_addrs'           => $this->input->ip_address(),
                                    'acct_name'          => $this->input->post('txtacctname'),
                                    'bank_name'          => $this->input->post('txtbank'),
                                    'acct_no'            => $this->input->post('txtacctno')
                                );
                            }
                            
                        }
                        
                        $newdata3 = $this->security->xss_clean($newdata3);
                        //echo $txtmember."mmm"
                        if($txtmember==""){
                            $querys0 = $this->sql_models->check_bma_details_ref($this->input->post('email1'), $this->input->post('phone1'));

                                if($querys0){
                                    $querys1 = $this->sql_models->update_insert_bma_members($newdata3, $this->input->post('email1'), $this->input->post('phone1'), '');
                                    if(!$querys1)
                                        echo "Error in network connection!";
                                    else{
                                        $now = 2147483647 - time();
                                        $cookie = array(
                                            'name'   => 'bma_customer_email_ref',
                                            'value'  => sha1($this->input->post('email1')),
                                            'expire' => $now,
                                            'secure' => FALSE
                                        );

                                        $cookie1 = array(
                                            'name'   => 'bma_customer_pas1_ref',
                                            'value'  => sha1($this->input->post('txtpass1')),
                                            'expire' => $now,
                                            'secure' => FALSE
                                        );
                                        set_cookie($cookie);
                                        set_cookie($cookie1);

                                        $trackid    = $this->input->post('trackid');
                                        $phone      = $this->input->post('phone');
                                        if($trackid != "")
                                        {
                                            $phone = $phone;
                                            $this->db->insert('reg_count',['phone'=>$phone]);
                                            $count = $this->db->get('reg_count')->num_rows();

                                            if($count % 3 == 0)
                                            {
                                                $lnk         = "https://postback.level23.nl/?currency=USD&handler";
                                                $lnk        .= "=10296&hash=e3d3f52dbcccacf662c0912dc7dc70b1&country=NG&payout=0.07&tracker=".$trackid;
                                                $ready       = curl_init();

                                                curl_setopt($ready, CURLOPT_URL, $lnk);
                                                curl_setopt($ready, CURLOPT_HEADER, 0); 
                                                curl_setopt($ready ,CURLOPT_RETURNTRANSFER,1);
                                                curl_setopt($ready, CURLOPT_CUSTOMREQUEST, 'GET');
                                                $da = curl_exec($ready);
                                            }
                                        }
                                        echo "done_2";
                                    }
                                }else{
                                    echo "Email or phone number already exists";
                                }
                            // }else{
                            //     echo "Your login credentials have not yet been approved!";
                            // }

                        }else{ // update
                            $querys1 = $this->sql_models->update_insert_bma_members($newdata3, $this->input->post('email1'), $this->input->post('phone1'), $txtmember);
                            echo "done_2";
                        }

                        $in_folder1="fake_fols/".$rename_file; // delete the image in the fake folder
                        if(is_readable($in_folder1)) @unlink($in_folder1);

                        $in_folder2="fake_fols/".$rename_file1; // delete the image in the fake folder
                        if(is_readable($in_folder2)) @unlink($in_folder2);
                    }
                }
            }
        }




        function fetch_featured_ads(){
            $mid = "";
            $fetch_data = $this->sql_models->make_datatables('featured_ads', '', '', '', '', '');
            
            $data = array();
            $conts = 1;
            foreach($fetch_data as $row)
            {
                $sub_array = array();
                $ids = $row->fa_id;
                $bp_id = $row->bp_id;
                $bp_approved = $row->bp_approved;
                $memids = $row->memid;
                $paids = $row->paid;
                $mem_name = $this->sql_models->getMemberID($memids);
                $mem_email = $this->sql_models->getBMA_Email($memids);

                $featured = $row->featured;
                $approved = $row->approved;
                $ad_plan = $row->ad_plan;
                $p_gateway = $row->payment_gateway;
                $sell_title = ucwords($row->sell_title);

                if($ad_plan=="360"){
                    $ad_plan = "3 days";
                    $txtplan1 = time()+259200; // add 72 hours (3days);
                }else if($ad_plan=="720") {
                    $ad_plan = "7 days";
                    $txtplan1 = time()+604800;
                }else if($ad_plan=="2880") {
                    $ad_plan = "1 month";
                    $txtplan1 = time()+2592000;
                }else if($ad_plan=="32400") {
                    $ad_plan = "1 year";
                    $txtplan1 = time()+31536000;
                }else {
                    $ad_plan = "";
                    $txtplan1 = "";
                }


                if($p_gateway=="mp") $p_gateway = "Bank Transfer";
                else $p_gateway = "Online Transaction";

                if($bp_approved == 1)
                    $bp_approved = "<font caps='Approved' id='approveuser' class='approveuser$bp_id' ids='".$bp_id."' style='color:#090; cursor:pointer'>Approved</font>";
                else
                    $bp_approved = "<font caps='Blocked' id='approveuser' class='approveuser$bp_id' ids='".$bp_id."' style='color:red; cursor:pointer'>Blocked</font>";
                $bp_approved .= "<font class='show_java1$bp_id' style='color:red'></font>";

                if($paids == 1)
                    $paids = "<font caps='Yes' ids='".$ids."' style='color:#090; cursor:default' onclick='javascript:alert(\"Cannot be undone!\");'><b>Yes</b></font>";
                else
                    $paids = "<font id='paiduser' class='paiduser$ids' caps='Not Paid' mem_name='".$mem_name."' mem_email='".$mem_email."' ids='".$ids."' bp_id='".$bp_id."' txtplan1='".$txtplan1."' style='color:red; cursor:pointer'>Not Paid</font>";
                $paids .= "<font class='show_java1_paid$ids' style='color:red'></font>";

                if($featured == 1)
                    $featured = "<font style='color:#090'>Yes</font>";
                else
                    $featured = "<font style='color:red' class='feat_no$ids'>No</font>";

                $price = $row->price;
                $countrys = $row->countrys;
                $states = $row->states;
                $citys = $row->citys;
                $descrip = $row->descrip;
                //$descrip = $descrip;
                $descrip = "<p>$descrip</p>";
                $dates = $row->dates;
                $timings = $row->timings;
                
                //$price = "&#8358;".@number_format($price);
                $locs = "$citys, $states - $countrys";
                $currentTime = time();
                $difference = $timings - $currentTime;
                $remainder = convertTime($difference);
                $hours_min_left=$remainder;

                if($timings <= 0){
                    $exprd = "<font style='color:#222; font-size:17px;'><b>---</b></font>";
                }else{
                    if($timings > $currentTime)
                        $exprd = "<font style='color:#090'>This Ad will expire in $remainder days </font>";
                    else
                        $exprd = "<font style='color:red'><b>Expired!</b></font>";
                }
                
                $btns1 = '<button class="btn btn-primary btn-xs edit_ads_ edit_invoice" captn="0" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.$states.'"><span class="glyphicon glyphicon-pencil"></span> </button> &nbsp;';

                $sub_array[] = $conts;
                $sub_array[] = ucwords($sell_title);
                $sub_array[] = $mem_name;
                $sub_array[] = $paids; // paid
                $sub_array[] = $featured;
                $sub_array[] = $bp_approved;
                $sub_array[] = $ad_plan; // ad_plan
                //$sub_array[] = $price;
                $sub_array[] = $locs;
                $sub_array[] = $p_gateway;
                $sub_array[] = $exprd;
                $sub_array[] = $descrip;
                $sub_array[] = $dates;
                //$sub_array[] = $btns1;
                
                $data[] = $sub_array;
                $conts++;
            }
            $output = array(
                "draw"              =>  intval($_POST["draw"]),
                "recordsTotal"      =>  $this->sql_models->get_all_data('featured_ads'),
                "recordsFiltered"   =>  $this->sql_models->get_filtered_data('featured_ads', '', '', '', '', ''),
                "data"              =>  $data
            );
            echo json_encode($output);
        }



        function fetch_videos_ads(){
            $mid = "";
            $fetch_data = $this->sql_models->make_datatables('adm_videos', '', '', '', '', '');
            
            $data = array();
            $conts = 1;
            foreach($fetch_data as $row)
            {
                $sub_array = array();
                $bp_id = $row->id;
                $bp_approved = $row->activates;
                $vid_title = $row->vid_title;
                $picx = $row->pics;
                $files = $row->files;
                $views = $row->views;
                $picx = str_replace(' ', '_', $picx);
                $files = str_replace(' ', '_', $files);

                if($picx!=''){
                $imgs1 = base_url()."admin_vids/$picx";
                $imgs1 = "<img src='$imgs1'>";
                }else{
                $imgs1 = base_url()."img/bms.jpg";
                $imgs1 = "<img src='$imgs1'>";
                }

                if($picx!=''){
                $vids1 = base_url()."admin_vids/$files";
                $vids1 = $files;
                }else{
                $vids1 = "";
                }
            
                if($bp_approved == 1)
                    $bp_approved = "<b caps='Deactivate' id='activate_vid' class='activate_vid$bp_id' ids='".$bp_id."' style='color:red; cursor:pointer'>Deactivate</b>";
                else
                    $bp_approved = "<b caps='Activate' id='activate_vid' class='activate_vid$bp_id' ids='".$bp_id."' style='color:#090; cursor:pointer'>Activate</b>";
                //$bp_approved .= "<font class='show_java1$bp_id' style='color:red'></font>";

                $btns1 = '<button class="btn btn-primary btn-xs edit_ads_ edit_vid_upload" captn="0" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.md5($bp_id).'"><span class="glyphicon glyphicon-pencil"></span> </button> &nbsp;';

                $sub_array[] = $conts;
                $sub_array[] = $bp_approved;
                $sub_array[] = ucwords($vid_title);
                $sub_array[] = $views;
                $sub_array[] = $imgs1;
                $sub_array[] = $vids1;
                $sub_array[] = $btns1;
                $data[] = $sub_array;
                $conts++;
            }
            $output = array(
                "draw"              =>  intval($_POST["draw"]),
                "recordsTotal"      =>  $this->sql_models->get_all_data('adm_videos'),
                "recordsFiltered"   =>  $this->sql_models->get_filtered_data('adm_videos', '', '', '', '', ''),
                "data"              =>  $data
            );
            echo json_encode($output);
        }




        function fetch_my_commission(){
            $mid = "";
            $get_bma_id_ref = $this->sql_models->getBMAID_ref();
            $fetch_data = $this->sql_models->make_datatables('submit_payments', '', $get_bma_id_ref, '', '', '');
            
            $data = array();
            $conts = 1;
            foreach($fetch_data as $row)
            {
                $sub_array = array();
                $ids = $row->fa_id;
                $bp_id = $row->bp_id;
                $memids = $row->refid;
                $paids = $row->paid;
                $commission = $row->commission;
                $requested_payme = $row->requested_payme;
                $mem_name = $this->sql_models->getMember($memids);
                //$mem_email = $this->sql_models->getBMA_Email($memids);
                $sell_title = ucwords($row->sell_title);
                $price = $row->payments;
                $dates = $row->dates;

                $price2 = "&#8358;".@number_format($price)." <font style='color:#990'>($commission% commission)</font>";

                if($paids == 1)
                    $paids = "<font style='color:#090; cursor:default'><b>Yes</b></font>";
                else
                    $paids = "<font style='color:red; cursor:pointer'>Not Paid</font>";
                $earnings = ($commission/100) * $price;

                $open_p=""; $open_p1="";
                if($requested_payme == 1){
                $open_p = "<p style='opacity:0.5'>";
                $open_p1 = "</p>";
                }

                $sub_array[] = $open_p.$conts.$open_p1;
                $sub_array[] = $open_p.$mem_name.$open_p1;
                $sub_array[] = $open_p.ucwords($sell_title).$open_p1;
                $sub_array[] = $open_p.$price2.$open_p1;
                $sub_array[] = $open_p."<font style='color:#990;'><b>&#8358;".$earnings."</b></font>".$open_p1;
                $sub_array[] = $open_p.$paids.$open_p1;
                $sub_array[] = $open_p.$dates.$open_p1;
                $data[]     = $sub_array;
                $conts++;
            }

            $output = array(
                "draw"              =>  intval($_POST["draw"]),
                "recordsTotal"      =>  $this->sql_models->get_all_data('featured_ads'),
                "recordsFiltered"   =>  $this->sql_models->get_filtered_data('featured_ads', '', '', '', '', ''),
                "data"              =>  $data
            );

            echo json_encode($output);
        }





        public function fetch_products(){
            $mid = "";
            $fetch_data = $this->sql_models->make_datatables('product_details', '', sha1($this->IDs), 'all_products', '', '');
            $data = array();
            $conts = 1;
            foreach($fetch_data as $row)
            {
                $sub_array = array();
                $ids = $row->id2;
                //$ids_ = md5($ids);
                $approved = $row->approved;
                if($approved == 1)
                    $approved = "<font style='color:#090'>Approved</font>";
                else
                    $approved = "<font style='color:red'>Pending Approval...</font>";
                $cat = ucwords($row->cat);
                $cat_name = $row->cat_name;
                $price = $row->price;
                $price = @number_format($price);
                $discount = $row->discount;
                $prod_name = ucwords($row->prod_name);
                $qty = $row->qty;
                $categoryy = "$cat | $cat_name";
                $sizes = $row->sizes;
                $colors = $row->colors;
                if($colors!="") $colors = "<b style='font-size:12px; color:#448;'>Colors:</b> $colors";
                if($sizes!="") $sizes = "<br><b style='font-size:12px; color:#448;'>Sizes:</b> $sizes";
                $color_size = "$colors $sizes";
                $date_reg = $row->date_reg;
                $imgs = $row->imgs;
                $descrip = $row->descrip;
                
                if($imgs != ""){
                    $file_ext1 = pathinfo($imgs, PATHINFO_EXTENSION);
                    $path_file1 = base_url()."products/".$imgs;
                    $imgs1 = "<p style='margin-top:5px;'><a href='$path_file1' target='_blank'><img src='$path_file1' class='img_sizes'></a></p>";
                }else{
                    $imgs1 = "";
                }
                
                $btns1 = '<button class="btn btn-primary btn-xs edit_ads_ edit_products" captn="0" data-title="Edit" data-toggle="modal" 
                data-target="#myPopup_" id="'.sha1($ids).'"><span class="fa fa-pencil"></span> </button>&nbsp;

                <button class="btn btn-danger btn-xs btn_delete" data-title="Delete" data-toggle="modal" 
                data-target="#delete_dv" for_id="'.$ids.'" for_page="products">
                <span class="fa fa-trash-o"></span></button>';

                $sub_array[] = $conts;
                $sub_array[] = $approved;
                $sub_array[] = $prod_name;
                $sub_array[] = $categoryy;
                $sub_array[] = $qty;
                $sub_array[] = "&#8358;".$price;
                $sub_array[] = $date_reg;
                $sub_array[] = $imgs1;
                $sub_array[] = $color_size;
                $sub_array[] = $descrip;
                $sub_array[] = $btns1;
                $data[] = $sub_array;
                $conts++;
            }
            $output = array(
                "draw"              =>  intval($_POST["draw"]),
                "recordsTotal"      =>  $this->sql_models->get_all_data('product_details'),
                "recordsFiltered"   =>  $this->sql_models->get_filtered_data('product_details', '', sha1($this->IDs), 'all_products', '', ''),
                "data"              =>  $data
            );
            echo json_encode($output);
            //echo "ssssss";
        }




        public function fetch_yourcus(){
            $mid = "";
            $fetch_data = $this->sql_models->make_datatables('customers', '', sha1($this->IDs), '', '', '');
            
            $data = array();
            $conts = 1;
            foreach($fetch_data as $row)
            {
                $sub_array = array();
                $ids = $row->id1;
                $fname = $row->fname;
                $lname = $row->lname;
                $emails = $row->emails;
                $phones = $row->phones;
                $cus = "$fname $lname";
                $cus = ucwords($cus);
                //$prod_name = $row->prod_name;
                $datesold = $row->datesold;


                $sub_array[] = $conts;
                $sub_array[] = $cus;
                $sub_array[] = "<a style='color:#090;' href='mailto:$emails' target='_blank'>$emails</a>";
                $sub_array[] = "<a style='color:#090;' href='tel:$phones'>$phones</a>";
                //$sub_array[] = $prod_name;
                $sub_array[] = $datesold;
                $data[] = $sub_array;
                $conts++;
            }
            $output = array(
                "draw"              =>  intval($_POST["draw"]),
                "recordsTotal"      =>  $this->sql_models->get_all_data('customers'),
                "recordsFiltered"   =>  $this->sql_models->get_filtered_data('customers', '', sha1($this->IDs), '', '', ''),
                "data"              =>  $data
            );
            echo json_encode($output);
            //echo "ssssss";
        }

        

        public function edit_profile(){
            if($this->sql_models->show_my_name()){
                $data['page_title'] = "Dashboard | Edit Profile - IDER";
                $data['page_name'] = "editprofile";
                $data['xauth_1'] = $this->xauth;
                $user_types = $this->input->cookie('user_types', TRUE);
                $data['user_types'] = $this->input->cookie('user_types', TRUE);
                $data['states1'] = $this->sql_models->fetchStates();
                $data['retrieve_data'] = $this->sql_models->get_profile();
                $data['show_name'] = $this->sql_models->show_my_name();
                $this->load->view("header", $data);
                $this->load->view("dashboard", $data);
                $this->load->view("footer");
            }else{
                redirect('node/login');
            }
        }

        public function changepassword(){
            if($this->sql_models->show_my_name()){
                $data['page_title'] = "Dashboard | Update Password - IDER";
                $data['page_name'] = "changepassword";
                $user_types = $this->input->cookie('user_types', TRUE);
                $data['user_types'] = $this->input->cookie('user_types', TRUE);
                $data['show_name'] = $this->sql_models->show_my_name();
                $data['xauth_1'] = $this->xauth;
                $data['states1'] = $this->sql_models->fetchStates();
                $this->load->view("header", $data);
                $this->load->view("dashboard", $data);
                $this->load->view("footer");
            }else{
                redirect('node/login');
            }
        }
        


        function approve_activities(){
            $session1 = $this->input->post('session1');
            $approve_it = $this->sql_models->approveActi($session1, '', '', 'set_weekly_activity');
            echo $approve_it;
        }


        function approve_contestants(){
            $ids = $this->input->post('ids');
            $approve_it = $this->sql_models->approveActi($ids, '', '', 'contestants');
            echo $approve_it;
        }


        function approve_paids(){
            $ids = $this->input->post('ids');
            $emails = $this->input->post('emails');
            $fname = $this->input->post('fname');
            $approve_it = $this->sql_models->approvePaids($ids, $emails, $fname, 'contestants');
            echo $approve_it;
        }


        function approve_paid_votes(){
            $ids = $this->input->post('ids');
            $amts = $this->input->post('amts');
            $fname = $this->input->post('fname');
            $emails = $this->input->post('emails');
            $approve_it = $this->sql_models->approvePaidsVotes($ids, $fname, $emails, $amts, 'all_votes');
            echo $approve_it;
        }


        function approve_paid_funds(){
            $ids = $this->input->post('ids');
            $amts = $this->input->post('amts');
            $fname = $this->input->post('fname');
            $phone = $this->input->post('phone');
            $approve_it = $this->sql_models->approvePaidsFunds($ids, $fname, $phone, $amts, 'fund_wallet_logs');
            //echo $approve_it;
        }


        function approve_activities_inner(){
            $ids1 = $this->input->post('ids1');
            $session1 = $this->input->post('session1');
            $game_type = $this->input->post('game_type');
            $approve_it = $this->sql_models->approveActi($ids1, $session1, $game_type, 'admin_set_activity2');
            echo $approve_it;
            //echo 1;
        }

        
        function close_activities(){
            $session1 = $this->input->post('session1');
            $approve_it = $this->sql_models->closeActi($session1, 'set_weekly_activity');
            echo $approve_it;
        }


        function approve_vds(){
            $ids = $this->input->post('ids');
            $approve_it = $this->sql_models->approveID($ids, '', '', 'adm_videos');
            echo $approve_it;
        }


        function approve_agent(){
            $ids = $this->input->post('ids');
            $approve_it = $this->sql_models->approveID($ids, '', '', 'bma_accounts');
            echo $approve_it;
        }


        function delete_member(){
            $ids = $this->input->post('ids');
            $deleteit = $this->sql_models->deleteMem($ids);
            //$deleteit = true;
            if($deleteit){
                echo "deleted";
            }else{
                echo "Failed";
            }
        }


        function approve_user_paid(){
            $ids = $this->input->post('ids');
            $txtplan1 = $this->input->post('txtplan1');
            $bp_id = $this->input->post('bp_id');
            $mem_names = $this->input->post('mem_names');
            $mem_email = $this->input->post('mem_email');

            $approve_it = $this->sql_models->approveID($ids, $txtplan1, $bp_id, 'featured_ads');
            //$approve_it=1;
            if($approve_it){
                $message_contents = "<div style='margin-top:0px; text-align:center;'><img src='https://bm.brandenvoy.mobi/img/bma_logo.png'></div>";
                $message_contents .= "<p style='font-size:14px; margin-top:25px'><b>Hello $mem_names,</b></p>";
                $message_contents .= "<p style='font-size:14px; margin-top:10px'>Your Ad on BrandMarket has been approved and featured, 
                you can now go to the platform and see it at the top of all other Ads where millions of users will see first before 
                other Ads.<br><br>Please if you still have any further questions, you can reach us on our contact page and we will get to you 
                immediately!</p>";

                $message_contents .= "<p style='font-size:14px; margin:10px 0 20px 0'>Thank you!</p>";
                $message_contents .= "<p style='margin-top:16px; line-height:1.5em; font-size:13px;'><b>Best Regards,</b><br>";
                $message_contents .= "<a href='https://bm.brandenvoy.mobi' style='color:#0066FF' target='_blank'>bm.brandenvoy.mobi</a></p>";

                $api_key= "2927c79e9f3e624977ac0d5b0c977504-c1fe131e-c11cad41";/* Api Key got from https://mailgun.com/cp/my_account */
                $domain = "righturngroup.com";/* Domain Name you given to Mailgun */
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'from' => "BrandMarket Ads Feature <info@bm.brandenvoy.mobi>",
                    'to' => $mem_email,
                    'subject' => "Your Ad Has Been Approved Successfully",
                    'html' => $message_contents
                ));

            //Todo: Open up so emails can go through
                $result = curl_exec($ch);
            //var_dump($result);
                curl_close($ch);
                echo $approve_it;
            }else{
                echo "Error!";
            }
        }


        function update_my_prof_pass(){
            $this->form_validation->set_rules('txtpass1', 'Old password', 'required|trim');
            $this->form_validation->set_rules('txtpass2', 'New password', 'required|trim|matches[txtpass3]');
            $this->form_validation->set_rules('txtpass3', 'confirm Password', 'required|trim');
            $user_types = $this->input->cookie('user_types', TRUE);

            if($this->form_validation->run() == FALSE){
                echo validation_errors();
            }else{
                $query = $this->sql_models->checkOldPass(sha1($this->input->post('txtpass1')), $user_types);

                if($query){
                    $updated = $this->sql_models->update_user_pass1(sha1($this->input->post('txtpass3')), $this->input->post('txtpass1'), $user_types);

                    if($updated){
                        $now = 2147483647 - time();

                        if($user_types == "for_merchant"){
                            $cookie = array(
                                'name'   => 'store_easer_pas1',
                                'value'  => sha1($this->input->post('txtpass3')),
                                'expire' => $now,
                                'secure' => FALSE
                            );

                            $cookie1 = array(
                                'name'   => 'user_types',
                                'value'  => 'for_merchant',
                                'expire' => '2147483647 - time()',
                                'secure' => FALSE
                            );

                        }else{

                            $cookie = array(
                                'name'   => 'store_customer_pas1',
                                'value'  => sha1($this->input->post('txtpass3')),
                                'expire' => $now,
                                'secure' => FALSE
                            );

                            $cookie1 = array(
                                'name'   => 'user_types',
                                'value'  => 'for_customer',
                                'expire' => '2147483647 - time()',
                                'secure' => FALSE
                            );
                        }
                        set_cookie($cookie);
                        set_cookie($cookie1);
                        echo "success_updated_pass1";

                    }else{
                        echo "Update failed to submit!";
                    }

                }else{
                    echo "This is not your old password!";
                }

            }
        }



        function logout(){
            //$now = 2147483647 - time();
            $cookie = array(
                'name'   => 'store_easer_pas1',
                'value'  => '',
                'expire' => '0',
                'secure' => FALSE
            );

            $cookie1 = array(
                'name'   => 'store_easer_usrs',
                'value'  => '',
                'expire' => '0',
                'secure' => FALSE
            );

            $cookie2 = array(
                'name'   => 'store_customer_pas1',
                'value'  => '',
                'expire' => '0',
                'secure' => FALSE
            );

            $cookie3 = array(
                'name'   => 'store_customer_usrs',
                'value'  => '',
                'expire' => '0',
                'secure' => FALSE
            );

            delete_cookie($cookie);
            delete_cookie($cookie1);
            delete_cookie($cookie2);
            delete_cookie($cookie3);
            redirect('node/login');
        }






















    }
