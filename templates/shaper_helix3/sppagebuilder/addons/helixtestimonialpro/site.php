<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2022 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

class SppagebuilderAddonHelixTestimonialpro extends SppagebuilderAddons
{

    public function render()
    {

        $settings = $this->addon->settings;
        $class = (isset($settings->class) && $settings->class) ? $settings->class : '';

        //Options
        $autoplay = (isset($settings->autoplay) && $settings->autoplay) ? ' data-sppb-ride="sppb-carousel"' : '';
        $controls = (isset($settings->controls) && $settings->controls) ? $settings->controls : 0;
        $arrow_controls = (isset($settings->arrow_controls) && $settings->arrow_controls) ? $settings->arrow_controls : 0;
        $interval = (isset($settings->interval) && $settings->interval) ? ((int) $settings->interval * 1000) : 5000;
        $avatar_shape = (isset($settings->avatar_shape) && $settings->avatar_shape) ? $settings->avatar_shape : 'sppb-avatar-circle';
        $show_quote = (isset($settings->show_quote)) ? $settings->show_quote : true;
        $avatar_on_top = (isset($settings->avatar_on_top)) ? $settings->avatar_on_top : 0;

        //Arrow icon
        $arrow_icon = (isset($settings->arrow_icon)) ? $settings->arrow_icon : 'chevron';
        $left_arrow = '';
        $right_arrow = '';
        if ($arrow_icon == 'angle_dubble') {
            $left_arrow = 'fa-angle-double-left';
            $right_arrow = 'fa-angle-double-right';
        } elseif ($arrow_icon == 'arrow') {
            $left_arrow = 'fa-arrow-left';
            $right_arrow = 'fa-arrow-right';
        } elseif ($arrow_icon == 'arrow_circle') {
            $left_arrow = 'fa-arrow-circle-o-left';
            $right_arrow = 'fa-arrow-circle-o-right';
        } elseif ($arrow_icon == 'long_arrow') {
            $left_arrow = 'fa-long-arrow-left';
            $right_arrow = 'fa-long-arrow-right';
        } elseif ($arrow_icon == 'angle') {
            $left_arrow = 'fa-angle-left';
            $right_arrow = 'fa-angle-right';
        } else {
            $left_arrow = 'fa-chevron-left';
            $right_arrow = 'fa-chevron-right';
        }

        //Output
        $output = '<div id="sppb-testimonial-pro-' . $this->addon->id . '" data-interval="' . $interval . '" class="sppb-carousel sppb-testimonial-pro sppb-slide ' . $class . '"' . $autoplay . '>';

        if ($controls) {
            $output .= '<ol class="sppb-carousel-indicators">';
            foreach ($settings->sp_testimonialpro_item as $key1 => $value) {
                $output .= '<li data-sppb-target="#sppb-carousel-' . $this->addon->id . '" ' . (($key1 == 0) ? ' class="active"' : '') . '  data-sppb-slide-to="' . $key1 . '"></li>' . "\n";
            }
            $output .= '</ol>';
        }

        if ($show_quote) {
            $output .= '<span class="fa fa-quote-left" aria-hidden="true"></span>';
        }
        $output .= '<div class="sppb-carousel-inner">';

        foreach ($settings->sp_testimonialpro_item as $key => $value) {
            $output .= '<div class="sppb-item ' . (($key == 0) ? ' active' : '') . '">';
            $name = (isset($value->title) && $value->title) ? $value->title : '';

            $avatar_img = isset($value->avatar) && $value->avatar ? $value->avatar : '';
            $carousel_img_src = isset($avatar_img->src) ? $avatar_img->src : $avatar_img;

            if ($avatar_on_top == 1) {
                $output .= $carousel_img_src ? '<img src="' . $carousel_img_src . '" class="' . $avatar_shape . '" alt="' . $name . '">' : '';
            }
            if (isset($value->message) && $value->message) {
                $output .= '<div class="sppb-testimonial-message">' . $value->message . '</div>';
            }
            $output .= '<div class="sppb-addon-testimonial-pro-footer">';
            if ($avatar_on_top != 1) {
                $output .= $carousel_img_src ? '<img src="' . $carousel_img_src . '" class="' . $avatar_shape . '" alt="' . $name . '">' : '';
            }
            $output .= '<div class="testimonial-pro-client-name-wrap">';
            $output .= $name ? '<span class="sppb-addon-testimonial-pro-client-name">' . $name . '</span>' : '';
            $output .= (isset($value->url) && $value->url) ? '&nbsp;<span class="sppb-addon-testimonial-pro-client-url">' . $value->url . '</span>' : '';
            $output .= (isset($value->designation) && $value->designation) ? '&nbsp;<span class="sppb-addon-testimonial-pro-client-designation">' . $value->designation . '</span>' : '';
            $output .= '</div>';
            $output .= '</div>';

            $output .= '</div>';
        }
        $output .= '</div>';

        if ($arrow_controls) {
            $output    .= '<a href="#sppb-testimonial-pro-' . $this->addon->id . '" class="left sppb-carousel-control" data-slide="prev" aria-label="' . Text::_('COM_SPPAGEBUILDER_ARIA_PREVIOUS') . '"><i aria-hidden="true" class="fa ' . $left_arrow . '"></i></a>';
            $output    .= '<a href="#sppb-testimonial-pro-' . $this->addon->id . '" class="right sppb-carousel-control" data-slide="next" aria-label="' . Text::_('COM_SPPAGEBUILDER_ARIA_NEXT') . '"><i aria-hidden="true" class="fa ' . $right_arrow . '"></i></a>';
        }

        $output .= '</div>';

        return $output;
    }

    public function css()
    {
        $addon_id = '#sppb-addon-' . $this->addon->id;
        $settings = $this->addon->settings;
        $cssHelper = new CSSHelper($addon_id);
        //Css output start
        $css = '';

        $settings->content_alignment = CSSHelper::parseAlignment($settings, 'content_alignment');

        $settings->speed = isset($settings->speed) ? $settings->speed : 600;
        $settings->avatar_width = isset($settings->avatar_width) ? $settings->avatar_width : (object) ['xl' => 32];

        // Avatar Style
        $css .=  $cssHelper->generateStyle('.sppb-testimonial-pro', $settings, ['content_alignment' => 'text-align'], false);
        $css .=  $cssHelper->generateStyle('.sppb-addon-testimonial-pro-footer', $settings, ['content_alignment' => 'justify-content'], false);
        $css .=  $cssHelper->generateStyle('.sppb-item > img', $settings, ['avatar_width' => ['width', 'height']]);
        $css .=  $cssHelper->generateStyle('.sppb-addon-testimonial-pro-footer img', $settings, ['avatar_width' => ['width', 'height']]);

        $css .= $cssHelper->generateStyle('.sppb-carousel-inner > .sppb-item', $settings, ['speed' => ['-webkit-transition-duration', 'transition-duration']], ['speed' => 'ms']);
        // Arrow Style
        $arrowStyleProps = [
            'arrow_height' => ['height', 'line-height'],
            'arrow_width' => 'width',
            'arrow_background' => 'background-color',
            'arrow_color' => 'color',
            'arrow_margin' => 'margin',
            'arrow_font_size' => 'font-size',
            'arrow_border_width' => 'border-width',
            'arrow_border_color' => 'border-color',
            'arrow_border_radius' => 'border-radius'
        ];
        $arrowStyleUnits = [
            'arrow_background'    => false,
            'arrow_color'         => false,
            'arrow_border_color'  => false
        ];

        $arrowStyle =  $cssHelper->generateStyle('.sppb-testimonial-pro .sppb-carousel-control', $settings, $arrowStyleProps, $arrowStyleUnits);
        //Arrow hover style
        $arrowHoverStyle =  $cssHelper->generateStyle('.sppb-testimonial-pro .sppb-carousel-control:hover', $settings, ['arrow_hover_background' => 'background-color', 'arrow_hover_color' => 'color', 'arrow_hover_border_color' => 'border-color'], false);
        // Icon Style
        $iconStyle = $cssHelper->generateStyle('.sppb-testimonial-pro .fa-quote-left', $settings, ['icon_color' => 'color', 'icon_size' => 'font-size'], ['icon_color' => false]);
        // Content Style
        $contentTypographyStyle = $cssHelper->typography('.sppb-testimonial-message', $settings, 'content_typography', [
            'font'           => 'content_font_family',
            'size'           => 'content_fontsize',
            'line_height'    => 'content_lineheight',
            'letter_spacing' => 'content_letterspace',
            'weight'         => 'content_fontstyle.weight',
            'uppercase'      => 'content_fontstyle.uppercase',
            'italic'         => 'content_fontstyle.italic',
            'underline'      => 'content_fontstyle.underline',
        ]);

        $contentStyle = $cssHelper->generateStyle('.sppb-testimonial-message', $settings, ['content_color' => 'color'], false);

        //Name style
        $nameTypographyStyle = $cssHelper->typography('.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name', $settings, 'name_typography', [
            'font'           => 'name_font_family',
            'size'           => 'name_font_size',
            'line_height'    => 'name_line_height',
            'letter_spacing' => 'name_letterspace',
            'weight'         => 'name_font_style.weight',
            'uppercase'      => 'name_font_style.uppercase',
            'italic'         => 'name_font_style.italic',
            'underline'      => 'name_font_style.underline',
        ]);

        $nameStyle = $cssHelper->generateStyle('.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name', $settings, ['name_color' => 'color'], ['name_color' => false]);
        // Designation style
        $designationTypographyStyle = $cssHelper->typography('.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation', $settings, 'designation_typography', [
            'font'           => 'designation_font_family',
            'size'           => 'designation_font_size',
            'line_height'    => 'designation_line_height',
            'letter_spacing' => 'designation_letterspace',
            'weight'         => 'designation_font_style.weight',
            'uppercase'      => 'designation_font_style.uppercase',
            'italic'         => 'designation_font_style.italic',
            'underline'      => 'designation_font_style.underline',
        ]);

        $designationStyle = $cssHelper->generateStyle('.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation', $settings, ['designation_color' => 'color', 'designation_margin' => 'margin', 'designation_block' => 'display:block;'], ['designation_color' => false, 'designation_margin' => false, 'designation_block' => false], ['designation_margin' => 'spacing']);
        //Bullet style
        $bulletStyle = $cssHelper->generateStyle('.sppb-carousel-indicators li', $settings, ['bullet_border_color' => 'border-color'], false);
        $bulletActiveStyle = $cssHelper->generateStyle('.sppb-carousel-indicators li.active', $settings, ['bullet_active_bg_color' => 'background'], false);

        $css .= $arrowStyle;
        $css .= $arrowHoverStyle;
        $css .= $iconStyle;
        $css .= $contentTypographyStyle;
        $css .= $contentStyle;
        $css .= $nameTypographyStyle;
        $css .= $nameStyle;
        $css .= $designationTypographyStyle;
        $css .= $designationStyle;
        $css .= $bulletStyle;
        $css .= $bulletActiveStyle;

        return $css;
    }

    public static function getTemplate()
    {

        $lodash = new Lodash('#sppb-addon-{{ data.id }}');
        $output = '
            <#
                let interval = (data.interval)? (data.interval*1000):5000
                let autoplay = (data.autoplay)? \'data-sppb-ride="sppb-carousel"\':""
                let avatar_size = data.avatar_width || 32
                let avatar_shape = data.avatar_shape || "sppb-avatar-circle"
                let arrow_icon = (!_.isEmpty(data.arrow_icon)) ? data.arrow_icon : "chevron";
                let left_arrow ="";
                let right_arrow = "";
                if(arrow_icon=="angle_dubble"){
                    left_arrow ="fa-angle-double-left";
                    right_arrow = "fa-angle-double-right";
                } else if(arrow_icon=="arrow"){
                    left_arrow ="fa-arrow-left";
                    right_arrow = "fa-arrow-right";
                } else if(arrow_icon=="arrow_circle"){
                    left_arrow ="fa-arrow-circle-o-left";
                    right_arrow = "fa-arrow-circle-o-right";
                } else if(arrow_icon=="long_arrow"){
                    left_arrow ="fa-long-arrow-left";
                    right_arrow = "fa-long-arrow-right";
                } else if(arrow_icon=="angle"){
                    left_arrow ="fa-angle-left";
                    right_arrow = "fa-angle-right";
                } else{
                    left_arrow ="fa-chevron-left";
                    right_arrow = "fa-chevron-right";
                }
            #>
            <style type="text/css">';

        // Control
        $output .= $lodash->unit('width', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_width', 'px', false);
        $output .= $lodash->unit('height', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_height', 'px', false);
        $output .= $lodash->unit('font-size', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_font_size', 'px', false);
        $output .= $lodash->color('background-color', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_background');
        $output .= $lodash->color('color', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_color');
        $output .= $lodash->spacing('margin', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_margin');

        $output .= '<# if (data.arrow_height) { #>';
        $output .= $lodash->unit('line-height', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_height-data.arrow_border_width', 'px', false);
        $output .= '<# } #>';

        $output .= $lodash->unit('border-width', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_border_width', 'px', false);
        $output .= $lodash->unit('border-radius', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_border_radius', 'px', false);
        $output .= $lodash->border('border-color', '.sppb-testimonial-pro .sppb-carousel-control', 'data.arrow_border_color');

        // Control hover
        $output .= $lodash->border('border-color', '.sppb-testimonial-pro .sppb-carousel-control:hover', 'data.arrow_hover_border_color');
        $output .= $lodash->color('background-color', '.sppb-testimonial-pro .sppb-carousel-control:hover', 'data.arrow_hover_background');
        $output .= $lodash->color('color', '.sppb-testimonial-pro .sppb-carousel-control:hover', 'data.arrow_hover_color');

        // Image
        $output .= $lodash->unit('width', '.sppb-item > img, .sppb-addon-testimonial-pro-footer img', 'data.avatar_width', 'px');
        $output .= $lodash->unit('height', '.sppb-item > img, .sppb-addon-testimonial-pro-footer img', 'data.avatar_width', 'px');

        // Quote
        $output .= '<# if (data.show_quote) { #>';
        $output .= $lodash->unit('font-size', '.sppb-testimonial-pro .fa-quote-left', 'data.icon_size', 'px');
        $output .= $lodash->color('color', '.sppb-testimonial-pro .fa-quote-left', 'data.icon_color');
        $output .= '<# } #>';

        // Name
        $output .= $lodash->color('color', '.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name', 'data.name_color');

        $nameTypographyFallbcks = [
            'font'           => 'data.name_font_family',
            'size'           => 'data.name_font_size',
            'line_height'    => 'data.name_line_height',
            'letter_spacing' => 'data.name_letterspace',
            'weight'         => 'data.name_font_style?.weight',
            'uppercase'      => 'data.name_font_style?.uppercase',
            'italic'         => 'data.name_font_style?.italic',
            'underline'      => 'data.name_font_style?.underline',
        ];

        $output .= $lodash->typography('.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name', 'data.name_typography', $nameTypographyFallbcks);

        // Designation
        $output .= $lodash->color('color', '.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation', 'data.designation_color');
        $output .= '<# if (data.designation_block) { #>';
        $output .= 'display:block;';
        $output .= '<# } #>';
        $output .= $lodash->spacing('margin', '.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation', 'data.designation_margin');

        $designationTypographyFallbcks = [
            'font'           => 'data.designation_font_family',
            'size'           => 'data.designation_font_size',
            'line_height'    => 'data.designation_line_height',
            'letter_spacing' => 'data.designation_letterspace',
            'weight'         => 'data.designation_font_style?.weight',
            'uppercase'      => 'data.designation_font_style?.uppercase',
            'italic'         => 'data.designation_font_style?.italic',
            'underline'      => 'data.designation_font_style?.underline',
        ];
        $output .= $lodash->typography('.sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation', 'data.designation_typography', $designationTypographyFallbcks);

        // Content
        $contentTypographyFallbcks = [
            'font'           => 'data.content_font_family',
            'size'           => 'data.content_fontsize',
            'line_height'    => 'data.content_lineheight',
            'letter_spacing' => 'data.content_letterspace',
            'weight'         => 'data.content_fontstyle?.weight',
            'uppercase'      => 'data.content_fontstyle?.uppercase',
            'italic'         => 'data.content_fontstyle?.italic',
            'underline'      => 'data.content_fontstyle?.underline',
        ];
        $output .= $lodash->typography('.sppb-testimonial-message', 'data.content_typography', $contentTypographyFallbcks);
        $output .= $lodash->border('border-color', '.sppb-carousel-indicators li', 'data.bullet_border_color');
        $output .= $lodash->border('border-color', '.sppb-carousel-indicators li.active', 'data.bullet_active_bg_color');
        $output .= $lodash->border('border-width', '.sppb-carousel-indicators li', 'data.bullet_border_width');
        $output .= $lodash->color('background-color', '.sppb-carousel-indicators li.active', 'data.bullet_active_bg_color');
        $output .= $lodash->color('color', '.sppb-testimonial-message', 'data.content_color');
        $output .= $lodash->spacing('margin', '.sppb-testimonial-message', 'data.content_margin');

        $output .= $lodash->alignment('text-align', '#sppb-testimonial-pro-{{ data.id }}', 'data.content_alignment');
        $output .= $lodash->alignment('justify-content', '.sppb-addon-testimonial-pro-footer', 'data.content_alignment');
        $output .= '
            </style>
            <div id="sppb-testimonial-pro-{{ data.id }}" data-interval="{{ interval }}" class="sppb-carousel sppb-testimonial-pro sppb-slide {{ data.class }}" {{{ autoplay }}}>

                <# if(data.controls) { #>
                    <ol class="sppb-carousel-indicators">
                    <#
                    _.each(data.sp_testimonialpro_item, function(item,key){
                        let activeClass
                        if (key == 0) {
                            activeClass = "class=active"
                        }else{
                            activeClass = ""
                        }
                    #>
                        <li data-sppb-target="#sppb-testimonial-pro-{{ data.id }}" {{ activeClass }} data-sppb-slide-to="{{ key }}"></li>
                    <# }) #>
                    </ol>
                <# } #>

                <# if(data.show_quote){ #>
                    <span class="fa fa-quote-left"></span>
                <# } #>
                <div class="sppb-carousel-inner">
                    <#
                    _.each(data.sp_testimonialpro_item, function(itemSlide, index) {
                        let slideActClass = ""
                        if (index == 0) {
                            slideActClass = " active"
                        } else {
                            slideActClass = ""
                        }
                    #>

                        <div class="sppb-item{{ slideActClass }}">
                            <#
                            var avatarImg = {}
                            if (typeof itemSlide.avatar !== "undefined" && typeof itemSlide.avatar.src !== "undefined") {
                                avatarImg = itemSlide.avatar
                            } else {
                                avatarImg = {src: itemSlide.avatar}
                            }
                            if (data.avatar_on_top === 1 || data.avatar_on_top) { 
                            if (!_.isEmpty(avatarImg.src)) { #>
                                <# if(avatarImg.src.indexOf("https://") == -1 && avatarImg.src.indexOf("http://") == -1){ #>
                                    <img class="{{ avatar_shape }}" src=\'{{ pagebuilder_base + avatarImg.src }}\' alt="">
                                <# } else { #>
                                    <img class="{{ avatar_shape }}" src=\'{{ avatarImg.src }}\' alt="">
                                <# } #>
                            <# }
                            } #>
                            <div class="sppb-testimonial-message sp-editable-content" id="addon-message-{{data.id}}-{{index}}" data-id={{data.id}} data-fieldName="sp_testimonialpro_item-{{index}}-message">{{{ itemSlide.message }}}</div>

                            <div class="sppb-addon-testimonial-pro-footer">
                            <# if (!data.avatar_on_top) {
                            if (avatarImg.src) { #>
                                <# if(avatarImg.src.indexOf("https://") == -1 && avatarImg.src.indexOf("http://") == -1){ #>
                                    <img class="{{ avatar_shape }}" src=\'{{ pagebuilder_base + avatarImg.src }}\' alt="">
                                <# } else { #>
                                    <img class="{{ avatar_shape }}" src=\'{{ avatarImg.src }}\' alt="">
                                <# } #>
                            <# }
                            } #>
                            <div class="testimonial-pro-client-name-wrap">
                            <# if( !_.isEmpty(itemSlide.title) ) { #>
                            <span class="sppb-addon-testimonial-pro-client-name">{{{ itemSlide.title }}}</span>
                            <# if( !_.isEmpty(itemSlide.url) ) { #>
                                &nbsp;<span class="sppb-addon-testimonial-pro-client-url">{{ itemSlide.url }}</span>
                            <# }
                            if( !_.isEmpty(itemSlide.designation) ) { #>
                                &nbsp;<span class="sppb-addon-testimonial-pro-client-designation">{{{ itemSlide.designation }}}</span>
                            <# }
                            } #>
                            </div>
                            </div>
                        </div>

                    <# }) #>
                </div>
                <# if(data.arrow_controls) { #>
                    <a href="#sppb-testimonial-pro-{{ data.id }}" class="left sppb-carousel-control" data-slide="prev"><i class="fa {{left_arrow}}"></i></a>
                    <a href="#sppb-testimonial-pro-{{ data.id }}" class="right sppb-carousel-control" data-slide="next"><i class="fa {{right_arrow}}"></i></a>
                <# } #>
            </div>
            ';

        return $output;
    }
}
