<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class EGUP_Glass_Card_Grid extends Widget_Base {

    public function get_name() { return 'egup_glass_card_grid'; }
    public function get_title() { return 'Glass Card Grid'; }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return ['basic']; }

    /* ========================= CONTROLS ========================= */
    protected function register_controls() {

        /* ---------- GRID SETTINGS ---------- */
        $this->start_controls_section('grid_settings',['label'=>'Grid Settings']);

        $this->add_control('layout',[
            'label'=>'Layout','type'=>Controls_Manager::SELECT,'default'=>'grid',
            'options'=>['grid'=>'Grid','row'=>'Horizontal','column'=>'Vertical'],
        ]);

        $this->add_responsive_control('columns',[
            'label'=>'Columns','type'=>Controls_Manager::SELECT,'default'=>'4',
            'options'=>['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6'],
            'condition'=>['layout'=>'grid'],
            'selectors'=>[
                '{{WRAPPER}} .egup-grid.layout-grid'=>'grid-template-columns:repeat({{VALUE}},1fr);',
            ],
        ]);

        $this->add_control('preset',[
            'label'=>'Card Preset','type'=>Controls_Manager::SELECT,'default'=>'glass',
            'options'=>['glass'=>'Glass','modern'=>'Modern','classic'=>'Classic'],
        ]);

        $this->end_controls_section();

        /* ---------- CARDS ---------- */
        $this->start_controls_section('cards_section',['label'=>'Cards']);

        $rep = new Repeater();

        $rep->add_control('media_type',[
            'label'=>'Media Type','type'=>Controls_Manager::SELECT,'default'=>'image',
            'options'=>['image'=>'Image','icon'=>'Icon'],
        ]);

        $rep->add_control('image',[
            'label'=>'Image','type'=>Controls_Manager::MEDIA,
            'default'=>['url'=>\Elementor\Utils::get_placeholder_image_src()],
            'condition'=>['media_type'=>'image'],
        ]);

        $rep->add_control('icon',[
            'label'=>'Icon','type'=>Controls_Manager::ICONS,
            'condition'=>['media_type'=>'icon'],
        ]);

        $rep->add_control('title',['label'=>'Title','type'=>Controls_Manager::TEXT,'default'=>'Glass Card Title']);
        $rep->add_control('desc',['label'=>'Description','type'=>Controls_Manager::TEXTAREA,'default'=>'Glassmorphism description text.']);
        $rep->add_control('btn_text',['label'=>'Button Text','type'=>Controls_Manager::TEXT,'default'=>'Learn More']);
        $rep->add_control('btn_link',['label'=>'Button Link','type'=>Controls_Manager::URL]);

        $this->add_control('items',[
            'type'=>Controls_Manager::REPEATER,
            'fields'=>$rep->get_controls(),
            'default'=>array_fill(0,4,[]),
        ]);

        $this->end_controls_section();

        /* ---------- IMAGE STYLE ---------- */
        $this->start_controls_section('image_style',['label'=>'Grid Image','tab'=>Controls_Manager::TAB_STYLE]);

        $this->add_responsive_control('img_width',['label'=>'Width','type'=>Controls_Manager::SLIDER,
            'selectors'=>['{{WRAPPER}} .egup-media img'=>'width: {{SIZE}}{{UNIT}};']]);

        $this->add_responsive_control('img_height',['label'=>'Height','type'=>Controls_Manager::SLIDER,
            'selectors'=>['{{WRAPPER}} .egup-media img'=>'height: {{SIZE}}{{UNIT}};']]);

        $this->add_control('img_object_fit',['label'=>'Object Fit','type'=>Controls_Manager::SELECT,'default'=>'cover',
            'options'=>['cover'=>'Cover','contain'=>'Contain'],
            'selectors'=>['{{WRAPPER}} .egup-media img'=>'object-fit: {{VALUE}};']]);

        $this->add_responsive_control('img_padding',['label'=>'Padding','type'=>Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} .egup-media'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);

        $this->add_responsive_control('img_align',['label'=>'Horizontal Align','type'=>Controls_Manager::CHOOSE,
            'options'=>[
                'flex-start'=>['icon'=>'eicon-text-align-left'],
                'center'=>['icon'=>'eicon-text-align-center'],
                'flex-end'=>['icon'=>'eicon-text-align-right'],
            ],
            'selectors'=>['{{WRAPPER}} .egup-media'=>'justify-content: {{VALUE}};']]);

        $this->add_responsive_control('img_vertical',['label'=>'Vertical Align','type'=>Controls_Manager::CHOOSE,
            'options'=>[
                'flex-start'=>['icon'=>'eicon-v-align-top'],
                'center'=>['icon'=>'eicon-v-align-middle'],
                'flex-end'=>['icon'=>'eicon-v-align-bottom'],
            ],
            'selectors'=>['{{WRAPPER}} .egup-media'=>'align-items: {{VALUE}};']]);

        $this->add_group_control(Group_Control_Border::get_type(),['name'=>'img_border','selector'=>'{{WRAPPER}} .egup-media img']);
        $this->add_responsive_control('img_radius',['label'=>'Border Radius','type'=>Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} .egup-media img'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(),['name'=>'img_shadow','selector'=>'{{WRAPPER}} .egup-media img']);

        $this->end_controls_section();

        /* ---------- ICON STYLE ---------- */
        $this->start_controls_section('icon_style',['label'=>'Grid Icon','tab'=>Controls_Manager::TAB_STYLE]);

        $this->add_responsive_control('icon_size',['label'=>'Size','type'=>Controls_Manager::SLIDER,
            'selectors'=>[
                '{{WRAPPER}} .egup-media i'=>'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .egup-media svg'=>'width: {{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};',
            ]]);

        $this->add_control('icon_color',['label'=>'Color','type'=>Controls_Manager::COLOR,
            'selectors'=>[
                '{{WRAPPER}} .egup-media i'=>'color: {{VALUE}};',
                '{{WRAPPER}} .egup-media svg'=>'fill: {{VALUE}};',
            ]]);

        $this->add_group_control(Group_Control_Background::get_type(),['name'=>'icon_bg','selector'=>'{{WRAPPER}} .egup-media']);
        $this->add_responsive_control('icon_padding',['label'=>'Padding','type'=>Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} .egup-media'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Border::get_type(),['name'=>'icon_border','selector'=>'{{WRAPPER}} .egup-media']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(),['name'=>'icon_shadow','selector'=>'{{WRAPPER}} .egup-media']);

        $this->end_controls_section();

        /* ---------- TITLE STYLE ---------- */
        $this->start_controls_section('title_style',['label'=>'Title','tab'=>Controls_Manager::TAB_STYLE]);

        $this->add_control('title_color',['label'=>'Color','type'=>Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .egup-title'=>'color: {{VALUE}};']]);

        $this->add_group_control(Group_Control_Typography::get_type(),['name'=>'title_typo','selector'=>'{{WRAPPER}} .egup-title']);

        $this->add_responsive_control('title_align',['label'=>'Alignment','type'=>Controls_Manager::CHOOSE,
            'options'=>[
                'left'=>['icon'=>'eicon-text-align-left'],
                'center'=>['icon'=>'eicon-text-align-center'],
                'right'=>['icon'=>'eicon-text-align-right'],
            ],
            'selectors'=>['{{WRAPPER}} .egup-title'=>'text-align: {{VALUE}};']]);

        $this->add_responsive_control('title_margin',['label'=>'Margin','type'=>Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} .egup-title'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);

        $this->end_controls_section();

        /* ---------- DESCRIPTION STYLE ---------- */
        $this->start_controls_section('desc_style',['label'=>'Description','tab'=>Controls_Manager::TAB_STYLE]);

        $this->add_control('desc_color',['label'=>'Color','type'=>Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .egup-desc'=>'color: {{VALUE}};']]);

        $this->add_group_control(Group_Control_Typography::get_type(),['name'=>'desc_typo','selector'=>'{{WRAPPER}} .egup-desc']);

        $this->add_responsive_control('desc_align',['label'=>'Alignment','type'=>Controls_Manager::CHOOSE,
            'options'=>[
                'left'=>['icon'=>'eicon-text-align-left'],
                'center'=>['icon'=>'eicon-text-align-center'],
                'right'=>['icon'=>'eicon-text-align-right'],
            ],
            'selectors'=>['{{WRAPPER}} .egup-desc'=>'text-align: {{VALUE}};']]);

        $this->add_responsive_control('desc_margin',['label'=>'Margin','type'=>Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} .egup-desc'=>'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);

        $this->end_controls_section();

        /* ---------- GRID STYLE ---------- */
        $this->start_controls_section('grid_style',['label'=>'Grid Style','tab'=>Controls_Manager::TAB_STYLE]);

        $this->add_group_control(Group_Control_Background::get_type(),['name'=>'grid_bg','selector'=>'{{WRAPPER}} .egup-card']);
        $this->add_group_control(Group_Control_Border::get_type(),['name'=>'grid_border','selector'=>'{{WRAPPER}} .egup-card']);
        $this->add_responsive_control('grid_radius',['label'=>'Border Radius','type'=>Controls_Manager::DIMENSIONS,
            'selectors'=>['{{WRAPPER}} .egup-card'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(),['name'=>'grid_shadow','selector'=>'{{WRAPPER}} .egup-card']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(),['name'=>'grid_shadow_hover','selector'=>'{{WRAPPER}} .egup-card:hover']);

        $this->end_controls_section();

        /* ---------- BUTTON STYLE ---------- */
        $this->start_controls_section('button_style',['label'=>'Button','tab'=>Controls_Manager::TAB_STYLE]);

        $this->add_group_control(Group_Control_Typography::get_type(),['name'=>'btn_typo','selector'=>'{{WRAPPER}} .egup-btn']);
        $this->add_control('btn_color',['label'=>'Text Color','type'=>Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .egup-btn'=>'color: {{VALUE}};']]);
        $this->add_control('btn_color_hover',['label'=>'Hover Text Color','type'=>Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .egup-btn:hover'=>'color: {{VALUE}};']]);
        $this->add_control('btn_bg',['label'=>'Background','type'=>Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .egup-btn'=>'background-color: {{VALUE}};']]);
        $this->add_control('btn_bg_hover',['label'=>'Hover Background','type'=>Controls_Manager::COLOR,
            'selectors'=>['{{WRAPPER}} .egup-btn:hover'=>'background-color: {{VALUE}};']]);
        $this->add_group_control(Group_Control_Border::get_type(),['name'=>'btn_border','selector'=>'{{WRAPPER}} .egup-btn']);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(),['name'=>'btn_shadow','selector'=>'{{WRAPPER}} .egup-btn']);

        $this->end_controls_section();
    }

    /* ========================= RENDER ========================= */
    protected function render() {
        $s = $this->get_settings_for_display(); ?>
        <div class="egup-grid layout-<?php echo esc_attr($s['layout']); ?> preset-<?php echo esc_attr($s['preset']); ?>">
            <?php foreach ($s['items'] as $item): ?>
                <div class="egup-card">
                    <div class="egup-media">
                        <?php
                        if ($item['media_type']==='icon') {
                            Icons_Manager::render_icon($item['icon'], ['aria-hidden'=>'true']);
                        } else {
                            echo '<img src="'.esc_url($item['image']['url']).'" alt="'.esc_attr($item['title']).'">';
                        }
                        ?>
                    </div>
                    <h3 class="egup-title"><?php echo esc_html($item['title']); ?></h3>
                    <p class="egup-desc"><?php echo esc_html($item['desc']); ?></p>
                    <?php if(!empty($item['btn_text'])): ?>
                        <a class="egup-btn" href="<?php echo esc_url($item['btn_link']['url']); ?>">
                            <?php echo esc_html($item['btn_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php }
}
