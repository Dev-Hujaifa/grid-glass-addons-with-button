<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class EGUP_Glass_Button_Pro extends Widget_Base {

    public function get_name() {
        return 'egup_glass_button_pro';
    }

    public function get_title() {
        return 'Glass Button Pro';
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['basic'];
    }

    /* ================= CONTENT ================= */
    protected function register_controls() {

        $this->start_controls_section('content', [
            'label' => 'Button Content',
        ]);

        $this->add_control('text', [
            'label' => 'Text',
            'type' => Controls_Manager::TEXT,
            'default' => 'Click Me',
        ]);

        $this->add_control('link', [
            'label' => 'Link',
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        $this->add_control('preset', [
            'label' => 'Preset',
            'type' => Controls_Manager::SELECT,
            'default' => 'glass',
            'options' => [
                'glass' => 'Glass',
                'neon' => 'Neon',
                'soft' => 'Soft',
                'gradient' => 'Gradient',
                'solid' => 'Solid',
                'outline' => 'Outline',
            ],
        ]);

        $this->add_control('align', [
            'label' => 'Alignment',
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => ['title'=>'Left','icon'=>'eicon-text-align-left'],
                'center' => ['title'=>'Center','icon'=>'eicon-text-align-center'],
                'right'  => ['title'=>'Right','icon'=>'eicon-text-align-right'],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .egup-btn' => 'justify-content: {{VALUE}};',
            ],
        ]);

        /* ===== MEDIA REPEATER ===== */
        $rep = new Repeater();

        $rep->add_control('media_type', [
            'label' => 'Type',
            'type' => Controls_Manager::SELECT,
            'default' => 'image',
            'options' => [
                'image' => 'Image',
                'icon'  => 'Icon',
            ],
        ]);

        $rep->add_control('image', [
            'label' => 'Image',
            'type' => Controls_Manager::MEDIA,
            'condition' => ['media_type'=>'image'],
        ]);

        $rep->add_control('icon', [
            'label' => 'Icon',
            'type' => Controls_Manager::ICONS,
            'condition' => ['media_type'=>'icon'],
        ]);

        $this->add_control('medias', [
            'label' => 'Images / Icons',
            'type' => Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
        ]);

        $this->add_control('media_position', [
            'label' => 'Media Position',
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'   => 'Left',
                'right'  => 'Right',
                'top'    => 'Top',
                'bottom' => 'Bottom',
            ],
        ]);

        $this->end_controls_section();

        /* ================= BUTTON STYLE ================= */
        $this->start_controls_section('btn_style', [
            'label' => 'Button Style',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            ['name'=>'btn_typo','selector'=>'{{WRAPPER}} .egup-btn']
        );

        $this->add_responsive_control('padding', [
            'label' => 'Padding',
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .egup-btn' =>
                'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            ['name'=>'btn_border','selector'=>'{{WRAPPER}} .egup-btn']
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            ['name'=>'btn_shadow','selector'=>'{{WRAPPER}} .egup-btn']
        );

        $this->end_controls_section();

        /* ================= MEDIA STYLE ================= */
        $this->start_controls_section('media_style', [
            'label' => 'Image / Icon Style',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('media_size', [
            'label' => 'Size',
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .egup-btn-media img' => 'width:{{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .egup-btn-media i'   => 'font-size:{{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .egup-btn-media svg' => 'width:{{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('media_gap', [
            'label' => 'Gap',
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .egup-btn' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('media_color', [
            'label' => 'Icon Color',
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .egup-btn-media i'   => 'color:{{VALUE}};',
                '{{WRAPPER}} .egup-btn-media svg' => 'fill:{{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    /* ================= RENDER ================= */
    protected function render() {

        $s = $this->get_settings_for_display();

        $this->add_render_attribute('btn', 'href', esc_url($s['link']['url']));
        $this->add_render_attribute('btn', 'class', [
            'egup-btn',
            'preset-' . $s['preset'],
            'media-' . $s['media_position']
        ]);

        if ( ! empty($s['link']['is_external']) ) {
            $this->add_render_attribute('btn', 'target', '_blank');
        }

        if ( ! empty($s['link']['nofollow']) ) {
            $this->add_render_attribute('btn', 'rel', 'nofollow');
        }
        ?>

        <a <?php echo $this->get_render_attribute_string('btn'); ?>>

            <?php if ( in_array($s['media_position'], ['left','top']) && ! empty($s['medias']) ): ?>
                <span class="egup-btn-media">
                    <?php foreach ($s['medias'] as $m):
                        if ($m['media_type']==='icon') {
                            Icons_Manager::render_icon($m['icon'], ['aria-hidden'=>'true']);
                        } else {
                            echo '<img src="'.esc_url($m['image']['url']).'" alt="">';
                        }
                    endforeach; ?>
                </span>
            <?php endif; ?>

            <span class="egup-btn-text"><?php echo esc_html($s['text']); ?></span>

            <?php if ( in_array($s['media_position'], ['right','bottom']) && ! empty($s['medias']) ): ?>
                <span class="egup-btn-media">
                    <?php foreach ($s['medias'] as $m):
                        if ($m['media_type']==='icon') {
                            Icons_Manager::render_icon($m['icon'], ['aria-hidden'=>'true']);
                        } else {
                            echo '<img src="'.esc_url($m['image']['url']).'" alt="">';
                        }
                    endforeach; ?>
                </span>
            <?php endif; ?>

        </a>
        <?php
    }
}
