<?php
 
/**
 * Description of Account
 *
 * @author vjallon
 */
class Account extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->library('aauth');
        $this->load->model('EnseignantModel');
        $this->load->library('form_validation');
    }
    
    public function verification($idAauth, $keyVerif)
    {
        
    }
    
    public function create()
    {
        // todo : vérifier si bon emplacement des  from_validation (P7)
        $this->form_validation->set_rules('MotDePasse','MotDePasse','required|max_length[100]');
        $this->form_validation->set_rules('ConfirmezVotreMotDePasse','Confirmez le mot de passe',"required|max_length[100]|callback_password_check");
        
        if ($this->form_validation->run()) {
            $password=$this->input->post('MotDePasse');
            $email=$this->input->post('Email');
            // créer le aauth_user à ajouter au controle de validation
            $idAauthUser=$this->aauth->create_user($email,$password);
            $params=array(
                'nom'=>$this->input->post('Nom'),
                'prenom'=>$this->input->post('Prenom'),
                'login'=>$email,
                'idAuth'=>$idAauthUser
            );
            // on crée l'enseignant
            $enseignant_id=$this->EnseignantModel->add_enseignant($params);
            // on l'affecte au groupe Enseignant
            $this->aauth->add_member($idAauthUser,'Enseignant');
            // redirect('Enseignant/Index');
            $this->attente_confirmation($email);
        }
        else {
            $data['title']='Inscription au rallye lecture';
            $this->load->view('AppHeader',$data);
            $this->load->view('AccountCreate');
            $this->load->view('AppFooter');
        }
        // echo "ok";
    }
    
    public function password_check()
    {
        $password = $this->input->post('MotDePasse');
        $passwordConfirmation = $this->input->post('ConfirmezVotreMotDePasse');
        if($password != $passwordConfirmation)
        {
            $this->form_validation->set_message('password_check','le mot de passe de confirmation est différent du mot de passe initial');
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function recaptcha_check($resp)
    {
        
    }
    
    public function edit()
    {
        
    }
    
    public function attente_confirmation($email)
    {
        $data['title'] = "Confirmation de votre inscription";
        $data['email'] = $email;
        $this->load->view('AppHeader',$data);
        $this->load->view('AccountConfirmation',$data);
        $this->load->view('AppFooter');
    }
    
    
    
    
}
