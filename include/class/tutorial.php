<?php

class Tutorial {
        # first Grade Variables
        public $title;
        public $tutorial_id;
        public $link;
        public $desc;
        public $type;
        public $img;
        private $type_id;
        public $category;
        public $cat_id;
        public $rate;
        private $like;
        private $hate;
        public $download;
        public $views;

        # Constructor Method
        public function __construct($request){
            $this->title = $request;
            $conn = new PDO("mysql:host=localhost;dbname=tutorial;", 'root', '0690997156h', array(PDO::ATTR_PERSISTENT => true));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # GET 't_id' 'link' 'descr'
            $stmt = $conn->prepare('SELECT * FROM course WHERE name = :name');
            $stmt->bindParam(':name', $request);
            $stmt->execute();
            while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
                $this->link = $rows['link'];
                $this->desc = $rows['descr'];
                $this->type_id = $rows['t_id'];
                $this->tutorial_id = $rows['id'];
                $this->img = $rows['image'];
            }
            # GET Download
            $s = $conn->prepare('SELECT t_id FROM downloads WHERE t_id = :id');
            $s->bindParam(':id', $this->tutorial_id);
            $s->execute();
            $downloads = array();
            while($que = $s->fetch(PDO::FETCH_NUM)){
                array_push($downloads, $que);
            }
            $this->download = count($downloads);

            # GET Views
            $s = $conn->prepare('SELECT t_id FROM visits WHERE t_id = :id');
            $s->bindParam(':id', $this->tutorial_id);
            $s->execute();
            $views = array();
            while($que = $s->fetch(PDO::FETCH_NUM)){
                array_push($views, $que);
            }
            $this->views = count($views);


            # GET 'tutorial Type'
            $stm = $conn->prepare('SELECT name, c_id FROM Types WHERE id = :id');
            $stm->bindParam(':id', $this->type_id);
            $stm->execute();
            while($que = $stm->fetch(PDO::FETCH_ASSOC)){
                $this->type = $que['name'];
                $this->cat_id = $que['c_id'];
                $this->img = "image/placeholder/".strtolower($this->type).".png";
            }
            # GET 'tutorial Category'
            $st = $conn->prepare('SELECT name FROM categories WHERE cat_id = :id');
            $st->bindParam(':id', $this->cat_id);
            $st->execute();
            while($qu = $st->fetch(PDO::FETCH_ASSOC)){
                $this->category = $qu['name'];
            }


        }
    public function link(){
        $con = "<div class='tutorial_link'><a href='../include/view_tut.php'>$this->title </a></div>";
        return $con;
    }

    public function box(){
        $con = "<div class='tutorial_boxs col-lg-3 col-md-4 col-sm-6 col-xs-12 thumb'>
                  <div class='thumbnail'>
                    <img src='$this->img' class='image-responsive thumbImg'>
                    <div class='caption'>
                        <h3 class='tutorial_title'>$this->title</h3>
                        <div class='tutorial_gender btn-group pull-right'>
                            <button type='button' onclick='refer(\"$this->category\", \"cat\")' class='btn btn-default btn-md'>$this->category</span>
                            <button type='button' class='btn btn-default btn-md' onclick='refer(\"$this->type\", \"type\")'>$this->type</span>
                        </div>
                        <span class='clearfix'></span>
                        <p  class='clearfix tutorial_desc'>$this->desc</p>
                        <span  class='tutorial_rate'>$this->rate</span>
                        <div class='row'>
                            <button type='button' onclick='save_act(\"$this->tutorial_id\", \"view\"); goto_page(\"include/class/tutorial.php?tutorial=$this->title\");' class='btn btn-success btn-md col-xs-10 col-xs-offset-1'>
                                <a href='javascript:void(0);'>View</a>
                            </button>
                        </div>
                    </div>
                  </div>
                </div>";
        return $con;
    }
    public function full(){
        $con = "
                    <div class='media row'>
                        <div class='col-xs-8 col-xs-offset-2 col-md-offset-0 col-md-4 col-lg-3'>
                            <img src='$this->img' class='media-object img-responsive img-thumbnail col-xs-12'/>
                        </div>
                        <div class='tutorial-body col-xs-10 col-xs-offset-1 col-md-7 col-md-offset-1'>
                            <h3 class='media-heading text-center'>$this->title</h3>
                            <div class='tutorial_gender btn-group pull-right'>
                                <button class='btn btn-default tutorial_cat'  onclick='refer(\"$this->category\", \"cat\")'>$this->category</button>
                                <button class='btn btn-default tutorial_type' onclick='refer(\"$this->type\", \"type\")'>$this->type</button>
                            </div>
                            <p class=\"clearfix\"></p>
                            <div class=\"row\">
                                <div class='tutorial_block1 col-xs-12 col-md-4'>
                                    <h4 class=\"text-primary\">Tutorial Description</h4>
                                    <span class='tutorial_desc'>$this->desc</span>
                                </div>
                                <div class='tutorial_block2 col-xs-12 col-md-8'>
                                    <span class='tutorial_add col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2'></span>
                                    <p class=\"clearfix\"></p>
                                    <div class='tutorial_rate col-xs-4'>
                                        <h4 class=\"text-primary\"> Rate</h4>
                                        <span>5/5</span>
                                    </div>
                                    <div class='tutorial_views col-xs-4'>
                                        <h4 class=\"text-primary\"> Views</h4>
                                        <span>$this->views</span>
                                    </div>
                                    <div class='tutorial_downloads col-xs-4'>
                                        <h4 class=\"text-primary\"> Downloads</h4>
                                        <span>$this->download</span>
                                    </div>
                                    <p class=\"clearfix\"></p>
                                    <div class=\"row\">
                                        <a  href='$this->link' target='_blank' class='tutorial_download'>
                                            <button class='btn btn-warning col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3' type='button' onclick='save_act(\"$this->tutorial_id\", \"download\"); window.open(\"$this->link\");'>
                                                <a onclick=''>Download</a>
                                            </button>
                                         </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
               ";
        return $con;
    }
}




if(isset($_REQUEST['type']) || isset($_REQUEST['cat'])){
    if(isset($_REQUEST['type'])) {
        $type = $_REQUEST['type'];
        $conn = new PDO("mysql:host=localhost;dbname=tutorial;", 'root', '0690997156h', array(PDO::ATTR_PERSISTENT => true));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        # Get The Tutorial Categorey ID
        $stmt = $conn->prepare('SELECT c_id FROM types WHERE name = :name');
        $stmt->bindParam(':name', $type);
        $stmt->execute();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $c_id = $rows['c_id'];
        }
        $stmt = $conn->prepare('SELECT name FROM categories WHERE cat_id = :id');
        $stmt->bindParam(':id', $c_id);
        $stmt->execute();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $c_name = $rows['name'];
        }
    } else {
        $c_name = $_REQUEST['cat'];

        # Set The Connection
        $conn = new PDO("mysql:host=localhost;dbname=tutorial;", 'root', '0690997156h', array(PDO::ATTR_PERSISTENT => true));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        # Get The Tutorial Categorey ID
        $stmt = $conn->prepare('SELECT cat_id FROM categories WHERE name = :name');
        $stmt->bindParam(':name', $c_name);
        $stmt->execute();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) { # Get The Category id For The Category Name.
            $c_id = $rows['cat_id'];
        }

    }
    try {
        # Get The Tutorial Type NAME & ID
        $i = 0; # Set Variable I as a COUNTER
        $t_id = array(); # Stock Types IDs
        $t_name = array(); # Stock Type NAMEs
        $stmt = $conn->prepare('SELECT name, id FROM types WHERE c_id = :id');
        $stmt->bindParam(':id', $c_id);
        $stmt->execute();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) { # GET The Types Under The Selected Category ID.
            $t_id[$i] = $rows['id'];
            $t_name[$i] = $rows['name'];
            $i++;
        }
        echo "<div class='page-header'>"; # Start Creating The Tabs
        echo "<h4>$c_name</h4>"; # The Categorey Name.
        echo "</div>";
        # Get The Tutorials For Each Type
        echo "<ul class='nav nav-pills'>";
        $full_type = array();
        $t_a = 0;
        # if The Tutorial Type is Set "Tutorial Active" Should Have Its Index in The "Tutorials names" Array
        # if NOT The Value will be Set to " 0 "
        for($j = 0; $j < count($t_id); $j++){ # Loop Inside Tutorial Types.
            if($type == $t_name[$j]){ # If The Query Came By Clicking a Specific Tuturial Type Make it Active By referring To it By $t_a Variable.
                $t_a = $j; # $t_a Holds an Id
            }
        }
        for($j = 0; $j < count($t_id); $j++){
            # Call All The Tutorials Of the Type XXX
            $stmt = $conn->prepare('SELECT name FROM course WHERE t_id  = :id');
            $stmt->bindParam(':id', $t_id[$j]);
            $stmt->execute();
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);
            if($j == $t_a){
                echo "<li class='active'>
                        <a href='#t".$t_id[$j]."' data-toggle='tab'>".$t_name[$j]
                    ."</a></li>";
            } else {
                echo "<li>
                        <a href='#t".$t_id[$j]."' data-toggle='tab'>".$t_name[$j]
                    ."</a></li>";
            }
        }
        echo "</ul>";
        echo "<div class='tab-content'>";

        for($j = 0; $j < count($t_id); $j++){
            if($j == $t_a){
                echo "<div class='tab-pane fade in row active' id='t".$t_id[$j]."'>";
            } else {
                echo "<div class='tab-pane fade row' id='t".$t_id[$j]."'>";
            }
            # Call All The Tutorials Of the Type XXX
            $stmt = $conn->prepare('SELECT name FROM course WHERE t_id  = :id');
            $stmt->bindParam(':id', $t_id[$j]);
            $stmt->execute();
            # Fetch The Courses Table
            while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){ # Get All The Tutorials Data Of the Type
                $tut_name = $rows['name'];
                $tut = new Tutorial($tut_name);

                echo  $tut->box();
            }
            echo "</div>";
        }
        echo "</div>";



    } catch(PDOException $err){
        echo $err->getMessage();
    }
}

if (isset($_REQUEST['tutorial'])) {
    $tut_name = $_REQUEST['tutorial'];
    $tut = new Tutorial($tut_name);
    echo $tut->full();
}
?>
