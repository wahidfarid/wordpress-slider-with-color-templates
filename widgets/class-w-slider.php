<?php
/**
 * Awesomesauce class.
 *
 * @category   Class
 * @package    WSLIDER
 * @subpackage WordPress
 * @author     Ben Marshall <me@benmarshall.me>
 * @copyright  2020 Ben Marshall
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://www.benmarshall.me/build-custom-elementor-widgets/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

namespace WSLIDER\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Awesomesauce widget class.
 *
 * @since 1.0.0
 */
class wSlider extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

        wp_register_style( 'w-slider', plugins_url( '/assets/css/w-slider.css', WSLIDER ), array(), '1.0.0' );
        wp_register_script( 'w-slider', plugins_url( '/assets/js/w-slider.js', WSLIDER ), array(), '1.0.0' );
    }

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'w-slider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'w-slider', 'w-slider' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}
	
	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'w-slider' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'w-slider' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'w-slider' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Title', 'w-slider' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'w-slider' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Description', 'w-slider' ),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'   => __( 'Content', 'w-slider' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __( 'Content', 'w-slider' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// $this->add_inline_editing_attributes( 'title', 'none' );
		// $this->add_inline_editing_attributes( 'description', 'basic' );
		// $this->add_inline_editing_attributes( 'content', 'advanced' );
		?>
		<!-- <h2 <?php echo $this->get_render_attribute_string( 'title' ); ?><?php echo wp_kses( $settings['title'], array() ); ?></h2>
		<div <?php echo $this->get_render_attribute_string( 'description' ); ?><?php echo wp_kses( $settings['description'], array() ); ?></div>
		<div <?php echo $this->get_render_attribute_string( 'content' ); ?><?php echo wp_kses( $settings['content'], array() ); ?></div> -->


        <!-- Slider main container -->
        <div class="w-slider-container swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/1.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/2.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/3.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/4.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/5.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/6.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/7.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/8.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/9.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/10.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/11.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/12.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/13.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/14.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/15.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/16.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/17.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/18.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/19.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/20.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/21.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/22.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/23.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/24.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/25.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/26.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/27.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/28.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/29.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/30.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/31.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/32.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/33.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/34.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/35.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/36.png)"></div>
            
        </div>
        <!-- If we need pagination -->
        <!-- <div class="swiper-pagination w-slider-pagination"></div> -->

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev w-slider-button-prev" onclick="swiper.slidePrev()"></div>
        <div class="swiper-button-next w-slider-button-next"></div>

        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar w-slider-scrollbar"></div>
        </div>


        <script>
            var swiper;
            document.addEventListener("DOMContentLoaded", function(event) { 
                swiper = new Swiper('.w-slider-container', {
                // Optional parameters
                loop: true,
                centeredSlides: true,
                initialSlide: 2,
                effect: 'fade',
                speed: 10,
                allowTouchMove: false,

                observer: true,
                observeParents: true,
                parallax:true,


                // If we need pagination
                // pagination: {
                //     el: '.w-slider-pagination',
                // },

                // Navigation arrows
                navigation: {
                    nextEl: '.w-slider-button-next',
                    prevEl: '.w-slider-button-prev',
                },

                // And if we need scrollbar
                scrollbar: {
                    el: '.w-slider-scrollbar',
                    draggable: true,
                    snapOnRelease: true,
                    hide: false,
                    dragSize: 50
                },
                });
                

                jQuery(".w-slider-button-prev").on("click", function(){
                    swiper.animating=false;
                    swiper.slidePrev();
                });
                jQuery(".w-slider-button-next").on("click", function(){
                    swiper.animating=false;
                    swiper.slideNext();
                })

            });
        </script>


		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<!-- <#
		view.addInlineEditingAttributes( 'title', 'none' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		view.addInlineEditingAttributes( 'content', 'advanced' );
		#>
		<h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
		<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
		<div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div> -->

        <!-- Slider main container -->
        <div class="w-slider-container swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/1.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/2.png)"></div>
            <div class="swiper-slide" style="background-image: url(http://toyotaelobour.com/wp-content/uploads/2021/02/3.png)"></div>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination w-slider-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev w-slider-button-prev"></div>
        <div class="swiper-button-next w-slider-button-next"></div>

        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar w-slider-scrollbar"></div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function(event) { 
                const swiper = new Swiper('.w-slider-container', {
                // Optional parameters
                loop: true,
                centeredSlides: true,
                effect: 'fade',
                speed: 10,


                // If we need pagination
                pagination: {
                    el: '.w-slider-pagination',
                },

                // Navigation arrows
                navigation: {
                    nextEl: '.w-slider-button-next',
                    prevEl: '.w-slider-button-prev',
                },

                // // And if we need scrollbar
                // scrollbar: {
                //     el: '.w-slider-scrollbar',
                //     // draggable: true,
                //     // snapOnRelease: true,
                //     // hide: false,
                //     // dragSize: 20,
                // },
                });
            });
        </script>

		<?php
	}
}