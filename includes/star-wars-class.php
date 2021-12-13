<?php

for ($nr=1;$nr<=4;$nr++){
    if ($nr==1){
        $url="https://swapi.dev/api/starships/";
       }
    elseif ($nr!=1){
        $url="https://swapi.dev/api/starships/$nr";}
        echo $url;
}

class Star_Wars_Widget extends WP_Widget {



	function __construct() {
		parent::__construct(
			'starwars_widget', 
			esc_html__( 'Star Wars', 'stw_domain' ), 
			array( 'description' => esc_html__( 'Widget to display Star Wars Ships', 'stw_domain' ), ) 
		);
	}
	
	

	public function widget( $args, $instance ) {
		
		echo $args['before_widget']; 

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		

        //WIDGET CONTENT OUTPUT .
        display_api_data();
 
	}
	
	public function form( $instance ) {

		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Star Wars', 'stw_domain' );

		$ships = ! empty( $instance['ships'] ) ? $instance['ships'] : esc_html__( 'Star Wars', 'stw_domain' );
		?>

            <!-- Title-->
		<p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_attr_e( 'Title:', 'stw_domain' ); ?>
            </label> 

		    <input
             class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
             name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
             type="text" 
             value="<?php echo esc_attr( $title ); ?>">
		</p>
		
          <!-- DROPDOWN MENU-->
		  <p>
		    <label for="<?php echo esc_attr( $this->get_field_id( 'ships' ) ); ?>">
                <?php esc_attr_e( 'Ships:', 'stw_domain' ); ?>
            </label> 


		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

} 


    function get_API_data(){
       // $counter=0;

        for ($number=1;$number<=4;$number++){
    
           // $test=array();
            if($number==1){
                $url = "https://swapi.dev/api/starships/" ;
                $request = wp_remote_get($url);
                if(is_wp_error($request)){
                    return false;
                }
                $body = wp_remote_retrieve_body($request);
                $data = json_decode($body);
               // $testing=(array_merge($data));
               // return $data;
              echo '<pre>'. var_dump($data) .'</pre>';
              // $test=array_push($data);
              // var_dump($test);
              //return $data;
            }

            elseif ($number!=1){ 
                $url = "https://swapi.dev/api/starships/?page=$number";
                $request = wp_remote_get($url);
                if(is_wp_error($request)){
                return false;
                }

                $body = wp_remote_retrieve_body($request);
                $data = json_decode($body);
                echo '<pre>'. var_dump($data) .'</pre>';
               // $test=array_push($data);
               // var_dump($test);
               // return $data;
               // array_merge($data,$testing);
                 //return $data;
               //  return $testing;
      }
      //return $testing2;
      //return $testing;
      //$counter++;
    
    //sreturn $data;
    }
   return $data;
    //var_dump($test);
}



    function display_api_data(){
        $count = 0;
        $data = get_API_data();
        echo '<div>';
        echo '<select>';
        echo '<option>Chose Ship</option>';
        foreach($data->results as $r){
            echo  "<option value='ship-{$count}' >$r->name</option>";
            $count++;;
        }
        echo '</select>';
        echo '</div>';

        $count = 0;
        foreach($data->results as $r){
            echo "<div class='ship-{$count} box'>".PHP_EOL;
            echo "<div class='manufacturer'> Manufacturer: $r->manufacturer</div>".PHP_EOL;
            echo "<div class='cost_in_credits'>Cost in credits: $r->cost_in_credits</div>".PHP_EOL;
            echo "<div class='length'>Length: $r->length</div>".PHP_EOL;
            echo "<div class='max_atmosphering_speed'>Max atmosphering speed: $r->max_atmosphering_speed</div>".PHP_EOL;
            echo "<div class='crew'>Crew: $r->crew</div>".PHP_EOL;
            echo "<div class='passengers'>Passengers: $r->passengers</div>".PHP_EOL;
            echo "<div class='cargo_capacity'>Cargo Capactiy: $r->cargo_capacity</div>".PHP_EOL;
            echo "<div class='consumables'>Consumables: $r->consumables</div>".PHP_EOL;
            echo "<div class='hyperdrive_rating'>Hyperdrive rating: $r->hyperdrive_rating</div>".PHP_EOL;
            echo "<div class='MGLT'>MGLT: $r->MGLT</div>".PHP_EOL;
            echo "<div class='starship_class'>Starship class: $r->starship_class</div>".PHP_EOL;
            echo '</div>';
            $count++;
        }

    }


    