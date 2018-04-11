<?php

/** @property LivreModel $livreModel 
 *  @property AuteurModel $auteurModel 
 *  @property Editeurmodel $editeurModel 
 *  @property Quizzmodel $quizzModel 
 */
class Livre extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        
        // ----- Modifs pour UPLOAD d'images ----- \\
        $config['upload_path']='./img/.';
        $config['allowed_types']='gif|jpg|png|jpeg';
        $config['overwrite']=TRUE;
        $config['max_size']='2000';
        $config['max_width']='1024';
        $config['max_height']='768';
        $this->load->library('upload',$config);
        // ---------- \\
        
        $this->load->model('livreModel');
        $this->load->model('auteurModel');
        $this->load->model('editeurModel');
        $this->load->model('quizzModel');
        // Modif \\
        $this->load->library('pagination');
    }

    function index() {
        $config['base_url']=site_url().'/Livre/index/page';
        $page = $this->uri->segment(4,0);
        // $config['total_rows'] = $this->livreModel->get_count();
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 15;
        $config['num_tag_open'] = ' ';
        $config['num_tag_close'] = ' ';
        
        
        $data['livres'] = $this->livreModel->get_all_livres($page,$config['per_page']);
        
        
        $config['total_rows'] = $this->livreModel->get_count();    // nombre de livres dans la BDD
        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();
        $data['title']='Les Livres';
        $data['links']=$links;
        $data['nombreLivres']=$this->livreModel->get_count();
        $this->load->view('AppHeader',$data);
        $this->load->view('LivreIndex',$data);
        $this->load->view('AppFooter',$data);          
    }
            
    function indexRechercheNom() {
        $config['base_url']=site_url().'/Livre/index/page';
        // $page = $this->uri->segment(4,0);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 15;
        $config['num_tag_open'] = ' ';
        $config['num_tag_close'] = ' ';
        
        
        $nom = $this->input->post("nom");
        $data['titre'] = $nom;
        $data['livres'] = $this->livreModel->get_livre_nom($nom);
        
        
        $config['total_rows'] = $this->livreModel->get_count();    // nombre de livres dans la BDD
        $this->pagination->initialize($config);
        $links = $this->pagination->create_links();
        $data['title']='Les Livres';
        $data['links']=$links;
        $data['nombreLivres'] = $this->livreModel->get_count();
        $this->load->view('AppHeader',$data);
        $this->load->view('LivreIndex',$data);
        $this->load->view('AppFooter',$data);        
    }
    
    function upload_image()
    {
        if(!$this->upload->do_upload('couverture'))
        {
           // $error = TRUE;
            $error = $this->upload->display_errors();
        }
        else
        {
            // $error = FALSE;
            $error = null;
        }
        return $error;
    }
    
    function add() {
        
        // ##### \\
        // $this->upload_image();
        // echo "name".$this->upload->file_name;
        // ##### \\
        
        $this->load->library('form_validation');
        LoadValidationRules($this->livreModel,$this->form_validation);
        $this->form_validation->set_rules('couverture', 'Couverture', 'callback_upload_image');    
        
        if ($this->form_validation->run())
        {
            
            $this->upload_image();
                $params=array(
                    'titre'=>$this->input->post('titre'),
                    // 'couverture'=>$this->input->post('couverture'),
                    'couverture'=>$this->upload->file_name,
                    //
                    'idAuteur'=>$this->input->post('idAuteur'),
                    'idEditeur'=>$this->input->post('idEditeur'),
                    'idQuizz'=>$this->input->post('idQuizz'),
                );
                $livre_id=$this->livreModel->add_livre($params);
            redirect('Livre/Index');
        }
        else
        {

        
            $all_auteurs=$this->auteurModel->get_all_auteurs();
            $all_editeurs=$this->editeurModel->get_all_editeurs();
            $all_quizz=$this->quizzModel->get_all_quizz();

            // chargement comboBox Auteur
            $cbProperties=array(
                'selectName'=>'idAuteur',
                'selectedAttributName'=>'id',
                'selectedValue'=>$this->input->post('idAuteur'),
                'optionAttributesNames'=>array('nom'),
                'options'=>$all_auteurs,
                'selectMessage'=>'sélectionnez un auteur',
                'emptyMessage'=>'aucun auteur à sélectionner'
            );
            $this->load->library('ComboBox',$cbProperties,'cbAuteur');
            $data['comboBoxAuteur']=$this->cbAuteur; // fin chargement comboBoxAuteur
            // chargement comboBox Editeur
            $cbProperties=array(
                'selectName'=>'idEditeur',
                'selectedAttributName'=>'id',
                'selectedValue'=>$this->input->post('idEditeur'),
                'optionAttributesNames'=>array('nom'),
                'options'=>$all_editeurs,
                'selectMessage'=>'sélectionnez un éditeur',
                'emptyMessage'=>'aucun éditeur à sélectionner'
            );
            $this->load->library('ComboBox',$cbProperties,'cbEditeur');
            $data['comboBoxEditeur']=$this->cbEditeur;
            $data['title']="Création d'un élève"; // fin chargement comboBoxEditeur
            // chargement comboBox Quizz
            $cbProperties=array(
                'selectName'=>'idQuizz',
                'selectedAttributName'=>'id',
                'selectedValue'=>$this->input->post('idQuizz'),
                'optionAttributesNames'=>array('idFiche'),
                'options'=>$all_quizz,
                'selectMessage'=>'sélectionnez un n° de fiche',
                'emptyMessage'=>'aucun n° de fiche à sélectionner'
            );
            $this->load->library('ComboBox',$cbProperties,'cbQuizz');
            $data['comboBoxQuizz']=$this->cbQuizz;// fin chargement comboBoxQuizz
            // todo : gérer création d'un nouveau livre (image etc)
            $data['title']="Création d'un livre";
            $this->load->view('AppHeader',$data);
            $this->load->view('LivreAdd',$data);
            $this->load->view('AppFooter');
        }
    }

    function edit($id) {
        $livre=$this->livreModel->get_livre($id);
        if (isset($livre['id'])) {
            $this->load->library('form_validation');
            LoadValidationRules($this->livreModel,$this->form_validation);
            if ($this->form_validation->run()) {
                $params=array(
                    'titre'=>$this->input->post('titre'),
                    'couverture'=>$this->input->post('couverture'),
                    'idAuteur'=>$this->input->post('idAuteur'),
                    'idEditeur'=>$this->input->post('idEditeur'),
                    'idQuizz'=>$this->input->post('idQuizz'),
                );

                $this->livreModel->update_livre($id,$params);
                redirect('Livre/Index');
            }
            else {
                $data['livre']=$livre;
                $all_auteurs=$this->auteurModel->get_all_auteurs();
                $all_editeurs=$this->editeurModel->get_all_editeurs();
                $all_quizz=$this->quizzModel->get_all_quizz();

                // chargement comboBox Auteur
                $cbProperties=array(
                    'selectName'=>'idAuteur',
                    'selectedAttributName'=>'id',
                    'selectedValue'=>$livre['idAuteur'],
                    'optionAttributesNames'=>array('nom'),
                    'options'=>$all_auteurs,
                    'selectMessage'=>'sélectionnez un auteur',
                    'emptyMessage'=>'aucun auteur à sélectionner'
                );
                $this->load->library('ComboBox',$cbProperties,'cbAuteur');
                $data['comboBoxAuteur']=$this->cbAuteur; // fin chargement comboBoxAuteur
                // chargement comboBox Editeur
                $cbProperties=array(
                    'selectName'=>'idEditeur',
                    'selectedAttributName'=>'id',
                    'selectedValue'=>$livre['idEditeur'],
                    'optionAttributesNames'=>array('nom'),
                    'options'=>$all_editeurs,
                    'selectMessage'=>'sélectionnez un éditeur',
                    'emptyMessage'=>'aucun éditeur à sélectionner'
                );
                $this->load->library('ComboBox',$cbProperties,'cbEditeur');
                $data['comboBoxEditeur']=$this->cbEditeur;
                $data['title']="Création d'un élève"; // fin chargement comboBoxEditeur
                // chargement comboBox Quizz
                $cbProperties=array(
                    'selectName'=>'idQuizz',
                    'selectedAttributName'=>'id',
                    'selectedValue'=>$livre['idQuizz'],
                    'optionAttributesNames'=>array('idFiche'),
                    'options'=>$all_quizz,
                    'selectMessage'=>'sélectionnez un n° de fiche',
                    'emptyMessage'=>'aucun n° de fiche à sélectionner'
                );
                $this->load->library('ComboBox',$cbProperties,'cbQuizz');
                $data['comboBoxQuizz']=$this->cbQuizz;// fin chargement comboBoxQuizz
                //
                $data['title']="Modification d'un livre";
                $this->load->view('AppHeader',$data);
                $this->load->view('LivreEdit',$data);
                $this->load->view('AppFooter');
            }
        }
        else
            show_error("Le livre que vous tentez de modifier n'existe pas.");
    }

    function remove($id) {
        $livre=$this->livreModel->get_livre($id);
        if (isset($livre['id'])) {
            $this->livreModel->delete_livre($id);
            redirect('livre/index');
        }
        else
            show_error("Le livre que vous tentez de supprimer n'existe pas.");
    }

    function supprimer($ids)
    {
        $this->load->view('LivreSuppression',$ids);
    }
}