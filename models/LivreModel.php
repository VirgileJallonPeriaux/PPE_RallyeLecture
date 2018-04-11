<?php

/**  @property AuteurModel $hasOneAuteur 
 *   @property Editeurmodel $hasOneEditeur 
 *   @property Quizzmodel $hasOneQuizz 
 */
class LivreModel extends CI_Model {
    public $ValidationRules=array(
        array('field'=>'titre','label'=>'Titre','rules'=>'required|max_length[45]'),
        array('field'=>'couverture','label'=>'Couverture','rules'=>'max_length[100]'),
        array('field'=>'idAuteur','label'=>'idAuteur','rules'=>'required|integer'),
        array('field'=>'idEditeur','label'=>'idEditeur','rules'=>'required|integer'),
        array('field'=>'idQuizz','label'=>'idQuizz','rules'=>'integer')
    );

    // ----- modif --- \\
    private $_count;

    function __construct() {
        parent::__construct();
        $this->load->model('auteurModel','hasOneAuteur');
        $this->load->model('editeurModel','hasOneEditeur');
        $this->load->model('quizzModel','hasOneQuizz');
        $this->_count = 0;
    }

    function get_livre($id) {
        $retour = $this->db->get_where('livre',array('id'=>$id))->row_array();
        $this->_count = count($retour);
        return $retour;
    }
    
    function get_livre_nom($nom) {
        $this->db->select('*');
        $this->db->from('livre');
        $this->db->like('titre', $nom , 'after');
        $retour = $this->db->get()->result_array();
        $this->_count = count($retour);
        return $retour;
    }
    
    /*function get_livre_nom($nom , $start = NULL, $count = NULL) {
        
        if( isset($start) && isset($count) )
        {
            $this->db->select('*');
            $this->db->from('livre');
            $this->db->like('titre', $nom , 'after');
            $this->db->limit($start , $count);
            $retour = $this->db->get()->result_array();
            $this->_count = count($retour);
        }
        else
        {
            $this->db->select('*');
            $this->db->from('livre');
            $this->db->like('titre', $nom , 'after');
            $retour = $this->db->get()->result_array();
            $this->_count = count($retour);
        }
               
        return $retour;
    }*/



    // ----- fonction à modifier --- \\
    function get_all_livres($start = NULL, $count = NULL)
    {
        // Code initial
        // return $this->db->get('livre')->result_array();

        $resultatRequete = $this->db->get('livre')->result_array();
        $this->_count = count($resultatRequete);
        if( isset($start) && isset($count) )
        {
            $resultatRequete = $this->db->get('livre',$count,$start)->result_array();
            // $this->_count = count($resultatRequete);
        }
        
        // echo "Nombre de livre(s) : ".$this->get_count();
        return $resultatRequete;
    }

    public function get_count()
    {
        // echo "Count : ".$this->_count;
        return $this->_count;
    }


    function add_livre($params) {
        $this->db->insert('livre',$params);
        return $this->db->insert_id();
    }

    function update_livre($id,$params) {
        $this->db->where('id',$id);
        $this->db->update('livre',$params);
    }

    function delete_livre($id) {
        $this->db->delete('livre',array('id'=>$id));
    }

    function get_auteur($id) {
        $idAuteur=$this->db->get_where('livre',array('id'=>$id))->row_array()['idAuteur'];
        return $this->hasOneAuteur->get_auteur($idAuteur);
    }

    function get_editeur($id) {
        $idEditeur=$this->db->get_where('livre',array('id'=>$id))->row_array()['idEditeur'];
        return $this->hasOneEditeur->get_editeur($idEditeur);
    }

    function get_quizz($id) {
        $idQuizz=$this->db->get_where('livre',array('id'=>$id))->row_array()['idQuizz'];
        return $this->hasOneQuizz->get_quizz($idQuizz);
    }

}