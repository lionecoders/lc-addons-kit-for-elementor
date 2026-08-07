<?php
/**
 * Breadcrumbs Widget
 *
 * @package LC_Elementor_Addons_Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

class LCAKE_Kit_Breadcrumbs extends \Elementor\Widget_Base {

    public function get_name() {
        return 'lcake-kit-breadcrumbs';
    }

    public function get_categories() {
        return ['lcake-page-kit'];
    }

    public function get_title() {
        return esc_html__('Breadcrumbs', 'lc-addons-kit-for-elementor');
    }

    public function get_icon() {
        return 'eicon-share-arrow';
    }

    public function get_style_depends() {
        return ['lcake-kit-breadcrumbs-css'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_home',
            [
                'label' => esc_html__('Show Home Link', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'home_text',
            [
                'label' => esc_html__('Home Text', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Home', 'lc-addons-kit-for-elementor'),
                'condition' => ['show_home' => 'yes'],
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => esc_html__('Separator', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slash',
                'options' => [
                    'slash' => '/',
                    'dot' => '•',
                    'arrow' => '→',
                    'chevron' => '›',
                ],
            ]
        );

        $this->add_control(
            'show_current',
            [
                'label' => esc_html__('Show Current Page', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_breadcrumbs',
            [
                'label' => esc_html__('Breadcrumbs', 'lc-addons-kit-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => esc_html__('Left', 'lc-addons-kit-for-elementor'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => esc_html__('Center', 'lc-addons-kit-for-elementor'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => esc_html__('Right', 'lc-addons-kit-for-elementor'), 'icon' => 'eicon-text-align-right'],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .lcake-breadcrumbs' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Link Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-breadcrumbs-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'current_color',
            [
                'label' => esc_html__('Current Page Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-breadcrumbs-item.is-current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label' => esc_html__('Separator Color', 'lc-addons-kit-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lcake-breadcrumbs-separator' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumbs_typography',
                'selector' => '{{WRAPPER}} .lcake-breadcrumbs',
            ]
        );

        $this->end_controls_section();
    }

    private function get_trail($settings) {
        $trail = [];

        if ('yes' === $settings['show_home']) {
            $trail[] = ['text' => $settings['home_text'], 'url' => home_url('/')];
        }

        if (is_singular()) {
            $post = get_post();
            $post_type_obj = get_post_type_object($post->post_type);

            if ($post_type_obj && !$post_type_obj->_builtin && $post_type_obj->has_archive) {
                $trail[] = ['text' => $post_type_obj->labels->name, 'url' => get_post_type_archive_link($post->post_type)];
            }

            if (is_post_type_hierarchical($post->post_type)) {
                $parents = [];
                $parent_id = $post->post_parent;
                while ($parent_id) {
                    $parent = get_post($parent_id);
                    if ($parent) {
                        $parents[] = [
                            'text' => get_the_title($parent),
                            'url' => get_permalink($parent->ID),
                        ];
                        $parent_id = $parent->post_parent;
                    } else {
                        break;
                    }
                }
                if (!empty($parents)) {
                    $trail = array_merge($trail, array_reverse($parents));
                }
            } else {
                $categories = get_the_category($post->ID);
                if (!empty($categories)) {
                    $trail[] = ['text' => $categories[0]->name, 'url' => get_category_link($categories[0]->term_id)];
                }
            }

            $trail[] = ['text' => get_the_title($post), 'url' => '', 'current' => true];
        } elseif (is_category() || is_tag() || is_tax()) {
            $trail[] = ['text' => single_term_title('', false), 'url' => '', 'current' => true];
        } elseif (is_search()) {
            $trail[] = ['text' => sprintf(esc_html__('Search results for: %s', 'lc-addons-kit-for-elementor'), get_search_query()), 'url' => '', 'current' => true];
        } elseif (is_404()) {
            $trail[] = ['text' => esc_html__('404 Not Found', 'lc-addons-kit-for-elementor'), 'url' => '', 'current' => true];
        } elseif (is_home() || is_front_page()) {
            $trail[] = ['text' => esc_html__('Blog', 'lc-addons-kit-for-elementor'), 'url' => '', 'current' => true];
        } elseif (is_archive()) {
            $trail[] = ['text' => get_the_archive_title(), 'url' => '', 'current' => true];
        }

        return $trail;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $separators = ['slash' => '/', 'dot' => '&bull;', 'arrow' => '&rarr;', 'chevron' => '&rsaquo;'];
        $separator = $separators[$settings['separator']] ?? '/';
        $trail = $this->get_trail($settings);

        if (empty($trail)) {
            return;
        }
        ?>
        <nav class="lcake-breadcrumbs-wrapper" aria-label="<?php echo esc_attr__('Breadcrumb', 'lc-addons-kit-for-elementor'); ?>">
            <ol class="lcake-breadcrumbs">
                <?php foreach ($trail as $index => $item) :
                    if (!empty($item['current']) && 'yes' !== $settings['show_current']) {
                        continue;
                    }
                    $is_last = ($index === array_key_last($trail));
                    ?>
                    <li class="lcake-breadcrumbs-item<?php echo !empty($item['current']) ? ' is-current' : ''; ?>">
                        <?php if (!empty($item['url']) && empty($item['current'])) : ?>
                            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['text']); ?></a>
                        <?php else : ?>
                            <span><?php echo esc_html($item['text']); ?></span>
                        <?php endif; ?>
                    </li>
                    <?php if (!$is_last) : ?>
                        <li class="lcake-breadcrumbs-separator" aria-hidden="true"><?php echo $separator; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </nav>
        <?php
    }
}
