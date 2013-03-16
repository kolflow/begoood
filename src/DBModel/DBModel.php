<?php

/**
 *  abstract class DBModel
 *
 *  La Classe DBModel réalise un Active Record Générique pour le stockage DB
 *  Cette classe est faite pour être sous-classée
 *
 * 
 *  @author Jeremy Fix
 *  @author Gerome Canals
 *
 *  @package DBModel
 **/
abstract class DBModel implements JsonSerializable {

    /**
     *  Nom de la colonne Identifiant de l'objet dans la base
     *  @access protected
     *  @var string
     */
    protected $_oid; //='id';

    /**
     *  Nom du model
     *  
     *  @access protected
     *  @var String
     */
    protected $_mname = __CLASS__;

    /**
     *  Nom de la table correspondant au model
     *  par défaut le nom de la classe
     *  @access protected
     *  @var String
     */
    protected $_tname = __CLASS__;

    /**
     *  configuration à utiliser pour la connexion 
     *  à la base de données
     *  @access protected
     *  @var String
     */
    protected $_dbconfig;

    /**
     *  Gateway pour l'acces à la base
     *  @access protected
     *  @var iDBGateway
     */
    protected $gate;

    /*     * #@+
     *  @access protected
     *  @var array
     */

    /**
     *  tableau des attributs : attname=>type
     */
    protected $_a = array();

    /**
     *  tableau des valeur : attname=>val
     */
    protected $_v = array();

    /**
     *  tableau des attributs mis à jour: int=>attname
     */
    protected $_u = null;

    /**
     * Constantes pour orderby
     * @access public
     * @var string
     */

    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';
    const SINGLE = 0;
    const MULTI = 1;

    /**
     *  Constructeur d'objet
     *
     *  fabrique un nouvel objet vide
     */
    public function __construct($tval = null) {

        //$this->gate = DBGatewayFactory::getDBGateway($this->gateType) ;
        //$this->gate=DBGateway::getInstance();
        $this->gate = DBFactory::makeConnection($this->_dbconfig);
        if (!is_null($tval))
            $this->_v = $tval;
    }

    /**
     *
     *  Function returning a character string Printable
     * 	to verify compliance test
     *
     *  @return String
     */
    public function __toString2() {
        $string = "[" . $this->_mname . "::" . $this->_v[$this->_oid] . "]";
        foreach ($this->_a as $attname => $type) {
            $string .= " $attname : " . $this->_v[$attname] . " : ";
        }
        return $string;
    }

    /**
     *
     *  Function returning a character string Printable
     * 	to verify compliance test
     *
     *  @return String
     */
    public function __toString() {
        $string = "{ ";
        foreach ($this->_a as $attname => $type) {
            if ($type != 'array') {
                $string .= $attname . " : " . $this->_v[$attname] . ", ";
            } else {
                assert($type === 'Array');
                $string .= $attname . " : [";
                foreach ($this->_v[$attname] as $key => $value) {
                    $string.= $value . ", ";
                }
                $string = substr($values_query, 0, -2);
                $string .= " ]";
            }
        }
        $string = substr($string, 0, -2);
        $string .= " }";
        return $string;
    }

    /**
     *   Getter identifier generic
     *   And returns model identifier.
     *
     *   @return integer
     */
    public function getOid() {
        return $this->_v[$this->_oid];
    }

    /**
     *   Setter identifier 
     *   replaces the value of the model identifier by the value of the parameter
     */
    public function setOid($id) {
        $this->_v[$this->_oid] = $id;
    }

    /**
     *   Getter pour ModelName
     *
     *   retourne le nom du model
     *   @access public
     *   @return String
     */
    public function getModelName() {
        return $this->_mname;
    }

    /**
     *   Getter pour Storage Name
     *
     *   retourne le nom de stockage associé au model (table, fichier, type d'entrée ...)
     *   @access public
     *   @return String
     */
    public function getStorageName() {
        return $this->_tname;
    }

    /**
     *   Getter pour attributes
     *
     *   retourne lla liste des attributs du model
     *   @access public
     *   @return Array
     */
    public function getAttributes() {
        return $this->_a;
    }

    /**
     *   Getter pour valeurs
     *
     *   retourne le tableau des valeurs de l'objet 
     *   @access public
     *   @return Array
     */
    public function getValues() {
        return $this->_v;
    }

    /**
     *   Getter générique
     *
     *   fonction d'acc?s aux attributs d'un objet.
     *   Recoit en paramètre le nom de l'attribut accédé
     *   et retourne sa valeur.
     *  
     *   @access public
     *   @param String $attr_name attribute name 
     *   @return mixed
     */
    public function getAttr($attr_name) {
        if (array_key_exists($attr_name, $this->_a)) {
            return $this->_v[$attr_name];
        }
        $emess = $this->_mname . ": unknown attribute $attr_name (getAttr)";
        throw new ModelException($emess, 45);
    }

    /**
     *   fonction magique __get
     *   Ca mange pas de pain et permet de faire un peu de magie
     *   pour permettre l'accès aux attributs d'un objet.
     *   Recoit en paramètre le nom de l'attribut accédé
     *   et retourne sa valeur.
     *  
     *   @access public
     *   @param String $attr_name attribute name 
     *   @return mixed
     */
    public function __get($attr_name) {
        if (array_key_exists($attr_name, $this->_a)) {
            return $this->_v[$attr_name];
        }
        $emess = $this->_mname . ": unknown attribute $attr_name (getAttr)";
        throw new ModelException($emess, 45);
    }

    /**
     *   Setter générique
     *
     *   fonction de modification des attributs d'un objet.
     *   Re?oit en param?tre le nom de l'attribut modifi? et la nouvelle valeur
     *  
     *   @access public
     *   @param String $attr_name attribute name 
     *   @param mixed $attr_val attribute value
     *   @return mixed new attribute value
     */
    public function setAttr($attr_name, $attr_val) {
        if (array_key_exists($attr_name, $this->_a)) {
            $this->_v[$attr_name] = $attr_val;
            if (is_null($this->_u) || (!in_array($attr_name, $this->_u)))
                $this->_u[] = $attr_name;
            return $this->_v[$attr_name];
        }
        $emess = $this->_mname . ": unknown attribute $attr_name (setAttr)";
        throw new ModelException($emess, 45);
    }
    
     /**
     *   Setter générique
     *
     *   fonction de modification des attributs d'un objet.
     *   Re?oit en param?tre le nom de l'attribut modifi? et la nouvelle valeur
     *  
     *   @access public
     *   @param String $attr_name attribute name 
     *   @param mixed $attr_val attribute value
     *   @return mixed new attribute value
     */
    public function setAttrValues($data) {
        foreach ($data as $attr_name => $attr_val) {
             $this->setAttr($attr_name, $attr_val);
        }
    }


    /**
     *   fonction magique __set
     *
     *   Ca mange pas de pain et permet de faire un peu de magie
     *   pour la modification des attributs d'un objet.
     *   Recoit en paramètre le nom de l'attribut modifié et la nouvelle valeur
     *  
     *   @access public
     *   @param String $attr_name attribute name 
     *   @param mixed $attr_val attribute value
     *   @return mixed new attribute value
     */
    public function __set($attr_name, $attr_val) {
        if (array_key_exists($attr_name, $this->_a)) {
            $this->_v[$attr_name] = $attr_val;
            if (is_null($this->_u) || (!in_array($attr_name, $this->_u)))
                $this->_u[] = $attr_name;
            return $this->_v[$attr_name];
        }
        $emess = $this->_mname . ": unknown attribute $attr_name (setAttr)";
        throw new ModelException($emess, 45);
    }

    /**
     *   Suppression dans la base
     *
     *   Supprime la ligne dans la table corrsepondantà l'objet courant
     *   L'objet doit posséder un OID
     */
    public function delete() {

        if (!isset($this->_v[$this->_oid])) {
            throw new ModelException($this->_mname . ": Primary Key undefined : cannot delete");
        }
        $del_query = "delete from " . $this->_tname . " where `" . $this->_oid . "`= ?";

        $dbcon = $this->gate;

        try {
            $st = $dbcon->prepare($del_query);
            $r = $st->execute(array($this->_v[$this->_oid]));
        } catch (PDOException $e) {
            echo $del_query . "<br>";
            throw new GatewayException($e->getMessage());
        }
        return $r;
    }

    /**
     *   Insertion dans la base
     *
     *   Insère l'objet comme une nouvelle ligne dans la table
     *   
     *   @return int nombre de lignes insérées 
     */
    public function insert() {

        /**
         * building the query : 
         * insert into model-table (att1, att2, ..) values (?, ? .. )
         * with ? binded to att values in _v
         */
        $into_query = "insert into " . $this->_tname . " (`";
        $values_query = "values (";
        foreach ($this->_a as $attname => $attype) {
            $into_query .= $attname . "`,`";
            $values_query .= " ? ,";
            $values_array[] = ( isset($this->_v[$attname]) ? $this->_v[$attname] : 'null');
        }

        // suppress the last comma
        $into_query = substr($into_query, 0, -2);
        $values_query = substr($values_query, 0, -1);
        // close parenthesis
        $into_query .= ")";
        $values_query .= ")";

        $insert_query = $into_query . " " . $values_query;

        $dbcon = $this->gate;

        try {
            $st = $dbcon->prepare($insert_query);
            $r = $st->execute($values_array);
            $this->_v[$this->_oid] = $dbcon->lastInsertId($this->_tname);
            // set updated attributes to null
            $this->_u = null;
        } catch (PDOException $e) {
            echo $query . "<br>";
            throw new ModelException($e->getMessage());
        }


        return 1;
    }

    /**
     *   Mises à jour dans la base
     *
     *   Update la ligne de la base correspondant à  l'objet courant
     *   
     *   @return int nombre de lignes insérées 
     */
    public function update() {

        if (is_null($this->_u))
            return 0;
        if (!isset($this->_v[$this->_oid])) {
            throw new ModelException($this->_tname . ": Primary Key undefined : cannot update");
        }

        /*
         * building the query : 
         * update model_table set att = ?, att=? where id = Oid
         * for all atts in _u
         */
        $update_query = "update " . $this->_tname . " set `";
        foreach ($this->_u as $k => $attname) {
            $update_query .= "$attname` = ? ,`";
            $update_array[] = $this->_v[$attname];
        }

        $update_query = substr($update_query, 0, -2);
        $update_query .= " where `" . $this->_oid . "` = " . $this->_v[$this->_oid];

        $dbcon = $this->gate;

        try {
            $st = $dbcon->prepare($update_query);
            $r = $st->execute($update_array);
            // set updated attributes to null
            $this->_u = null;
        } catch (PDOException $e) {
            throw new ModelException($e->getMessage());
        }


        return 1;
    }

    /**
     *   Sauvegarde dans la base
     *
     *   Enregistre l'état de l'objet dans la table
     *   Si l'objet possède un identifiant : mise à jour de la ligne correspondante
     *   sinon : insertion dans une nouvelle ligne
     *
     *   @return int le nombre de lignes touchées
     */
    public function save() {
        if (!isset($this->_v[$this->_oid])) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    /**
     *   Finder sur ID`
     *
     *   Retrouve la ligne de la table correspondant au ID passé en paramètre,
     *   retourne un objet
     *  
     *   @static
     *   @param integer $id OID to find
     *   @return Model renvoie un objet de type Model
     */
    public function findById($id) {


        $query = "select * from " . $this->_tname . " where `" . $this->_oid . "`= ?";


        try {
            $sth = $this->gate->prepare($query);
            $sth->execute(array($id));
            //$sth=$this->gate->query($query) ;
        } catch (PDOException $e) {
            echo $e->__toString();
            exit();
        }
        if ($sth->rowCount() < 1)
            return null;


        $row = $sth->fetch(PDO::FETCH_ASSOC);
        $r = new $this->_mname();
        foreach ($this->_a as $att => $t)
            $r->setAttr($att, $row[$att]);

        return $r;
    }

    /**
     *   Finder All
     *
     *   Renvoie toutes les lignes de la table  
     *   sous la forme d'un tableau d'objet
     *  
     *   @return Array renvoie un tableau d'objets
     */
    public function findAll($orders = null) {
        $orderby = null;
        $ord = null;
        if (!is_null($orders)) {
            $orderby = $orders['orderby'];
            $ord = $orders['ord'];
        }
        $query = "select * from " . $this->_tname;
        if (!is_null($orderby)) {
            $query .= ' ORDER BY ' . $orderby . ' ';
            $query .= ( is_null($ord) ? DBModel::ORDER_ASC : $ord);
        }

        try {
            $sth = $this->gate->prepare($query);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->__toString();
            exit();
        }
        $all = null;
        if ($sth->rowCount() < 1)
            return null;

        foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $i => $row) {
            $r = new $this->_mname();
            foreach ($this->_a as $att => $t) {
                $r->setAttr($att, $row[$att]);
            }
            $all[] = $r;
        }

        return $all;
    }

    /**
     * find : recherche multi-critères
     * le paramètres contient des conditions de selection et d'ordonnancement du résultat
     * $params['conditions'] : array( array( att => value), ... ))
     * $params['orders']['orderby'] = 'att1, att2 ..'
     * $params['orders']['ord'] = DBModel::ORDER_ASC / DBModel::ORDER_DESC
     * 
     * @param Array $params 
     * @return Array renvoie le tableau d'objet correspondant au résultat de la requête
     */
    public function find($params = null) {

        if (is_null($params))
            return $this->findAll();
        if (!is_array($params))
            return $this->findById($params);
        if (is_null($params['conditions']))
            return $this->findAll($params['orders']);

        $query = "select * from " . $this->_tname . " where `";
        $conditions = $params['conditions'];
        $cond = array_shift($conditions);
        foreach ($cond as $att => $val) {
            switch ($this->_a[$att]) {
                case 'string': {
                        $query .= "$att` LIKE  ? ";
                        break;
                    }
                default: {
                        $query .= "$att` = ?";
                    }
            }
            $bind_val[] = $val;
        }

        foreach ($conditions as $cond) {
            foreach ($cond as $att => $val) {

                $query .= " AND ";
                switch ($this->_a[$att]) {
                    case 'string': {
                            $query .= "`$att` LIKE  ? ";
                            break;
                        }
                    default: {
                            $query .= "`$att` = ?";
                        }
                }
                $bind_val[] = $val;
            }
        }
        $ord = null;
        if (isset($param['orders']['ord'])) {
            $ord = $param['orders']['ord'];
        }
        if (isset($param['orders']['orderby'])) {
            $orderby = $param['orders']['orderby'];
            $query .= ' ORDER BY ' . $orderby . ' ';
            $query .= ( is_null($ord) ? DBModel::ORDER_ASC : $ord);
        }

        try {
            $sth = $this->gate->prepare($query);
            $sth->execute($bind_val);
        } catch (PDOException $e) {
            echo $e->__toString();
            exit();
        }
        $all = null;
        if ($sth->rowCount() < 1)
            return null;

        foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $i => $row) {
            $r = new $this->_mname();
            foreach ($this->_a as $att => $t) {
                $r->setAttr($att, $row[$att]);
            }
            $all[] = $r;
        }

        return $all;
    }

    /**
     *   Magic __call : pour traiter les finders findByAtt( .. )
     *
     *   Renvoie toutes les lignes de la table possédant la valeur 
     *   passée en paramètre de l'appel pour l'attribut apparaissant 
     *   dans le nom de la méthode,
     *   sous la forme d'un tableau d'objet
     *  
     *   @return Array renvoie un tableau d'objets
     */
    public function __call($method, $args) {


        $p = strpos($method, 'get');

        if (!($p === false)) {
            $att = strtolower(substr($method, 3));
            if (array_key_exists($att, $this->_a)) {
                return $this->_v[$att];
            } else
                return null;
        }


        $query = null;
        $bind_val = null;

        //extraire le nom de l'attribut
        $p = strpos($method, 'findBy');
        if ($p === false)
            return null;


        $att = strtolower(substr($method, 6));
        if (!array_key_exists($att, $this->_a)) {
            return null;
        }
        /* building the query : args[0] contains 
         * a value to be compared to the attribute
         * One single criteria : $att = $args[0]
         * args[1] may contain an ordering directive
         * query : 
         * select * from model_table where att = ?
         * with ? binded to $args[0]
         * special case with strings : like %args[0]%
         */

        $query = "select * from " . $this->_tname;
        $query .= " where $att ";
        switch ($this->_a[$att]) {
            case 'string': {
                    $query .= "LIKE  ? ";
                    break;
                }
            default: {
                    $query .= "= ?";
                }
        }
        $bind_val[] = $args[0];

        if (!is_null($args[1])) {
            $orderby = $args[1]['orderby'];
            $ord = $args[1]['ord'];
        }
        if (!is_null($orderby)) {
            $query .= ' ORDER BY ' . $orderby . ' ';
            $query .= ( is_null($ord) ? DBModel::ORDER_ASC : $ord);
        }


        try {
            $sth = $this->gate->prepare($query);
            $sth->execute($bind_val);
        } catch (PDOException $e) {
            echo $e->__toString();
            exit();
        }
        $all = null;
        if ($sth->rowCount() < 1)
            return null;

        foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $i => $row) {
            $r = new $this->_mname();
            foreach ($this->_a as $att => $t) {
                $r->setAttr($att, $row[$att]);
            }
            $all[] = $r;
        }

        return $all;
    }

    public function jsonSerialize() {
        return $this->_v;
    }

}
?>

