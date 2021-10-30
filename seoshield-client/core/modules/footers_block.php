<?php
/*
* модуль подменяет динамические мета данные
*/

if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

if (file_exists(SEOSHIELD_ROOT_PATH . '/core/lib/RobotsTxtParser.php')){
    include SEOSHIELD_ROOT_PATH . '/core/lib/RobotsTxtParser.php';    
}
if (file_exists(SEOSHIELD_ROOT_PATH . '/core/lib/RobotsTxtValidator.php')){
    include SEOSHIELD_ROOT_PATH . '/core/lib/RobotsTxtValidator.php';    
}

class SeoShieldModule_footers_block extends seoShieldModule
{
    private $robotsPath;

    public function __construct()
    {
        $this->robotsPath = $_SERVER["DOCUMENT_ROOT"] . '/robots.txt';
    }

    public function get_footers_block($out_html)
    {
        $d = [];
        $d['blocks_types'] = [
            'top-categories' => 'ТОП Категории',
            'top-filters' => 'ТОП Фильтры',
            'segments' => 'Сегменты',
            'top-pages' => 'ТОП Страницы',
            'top-tags' => 'ТОП Теги',
            'top-products' => 'ТОП Товары',
            'cities' => 'Города',
            'faq' => 'ЧаВо',
            'description' => 'Описание',
            'sentences' => 'Предложения',
        ];

        $blocks_info = [];
        $geo_info = [
            'nominative' => [],
            'genitive' => [],
            'dative' => [],
            'accusative' => [],
            'creative' => [],
            'prepositional' => [],
        ];
        $geo_info_by_lemma = [];
        $segments_info = [];
        $footers_data = include SEOSHIELD_ROOT_PATH.'/data/footers_config_data.php';
        if (!is_array($footers_data)) {
            $footers_data = [];
        }
        foreach ($footers_data as $type => $fds) {
            foreach ($fds as $fd_type => $fd) {
                $fd['type'] = $type;
                if (!isset($blocks_info[$fd['type']])) {
                    $blocks_info[$fd['type']] = [];
                }
                if ('cities' == $fd['type']) {
                    $geo_info['nominative'][] = $fd['nominative'];
                    $geo_info['genitive'][] = $fd['genitive'];
                    $geo_info['dative'][] = $fd['dative'];
                    $geo_info['accusative'][] = $fd['accusative'];
                    $geo_info['creative'][] = $fd['creative'];
                    $geo_info['prepositional'][] = $fd['prepositional'];
                    if (!isset($geo_info_by_lemma[$fd['lemma']])) {
                        $geo_info_by_lemma[$fd['nominative']] = [];
                    }
                    $geo_info_by_lemma[$fd['nominative']] = [
                        'nominative' => $fd['nominative'],
                        'genitive' => $fd['genitive'],
                        'dative' => $fd['dative'],
                        'accusative' => $fd['accusative'],
                        'creative' => $fd['creative'],
                        'prepositional' => $fd['prepositional'],
                    ];
                }
                if (in_array($fd['type'], ['top-categories', 'top-filters', 'segments', 'top-pages', 'top-tags', 'top-products'])) {
                    if (isset($fd['tags']) && is_array($fd['tags'])) {
                        foreach ($fd['tags'] as $tag) {
                            $tag = mb_strtolower($tag, 'utf8');
                            if (!isset($segments_info[$tag])) {
                                $segments_info[$tag] = [];
                            }
                            if ($fd['url'] === 'http:'.$GLOBALS['SEOSHIELD_CONFIG']['page_url'] || $fd['url'] === 'https:'.$GLOBALS['SEOSHIELD_CONFIG']['page_url']) {
                                continue;
                            }
                            $segments_info[$tag][] = ['url' => $fd['url'], 'anchor' => $fd['anchor']];
                        }
                    }
                    foreach ($fd['name_list'] as $nl) {
                        $nl = mb_strtolower($nl, 'utf8');
                        if (!isset($segments_info[$nl])) {
                            $segments_info[$nl] = [];
                        }
                        if ($fd['url'] === 'http:'.$GLOBALS['SEOSHIELD_CONFIG']['page_url'] || $fd['url'] === 'https:'.$GLOBALS['SEOSHIELD_CONFIG']['page_url']) {
                            continue;
                        }
                        $segments_info[$nl][] = ['url' => $fd['url'], 'anchor' => $fd['anchor']];
                    }
                }

                if ('description' == $fd['type']) {
                    unset($fd['type']);
                    $blocks_info[$type][$fd_type] = $fd;
                } else {
                    $blocks_info[$fd['type']][] = $fd;
                }
            }
        }

        $d['blocks_info'] = [];
        foreach ($d['blocks_types'] as $type => $b_title) {
            $d['blocks_info'][$type] = [];
            if (in_array($type, ['top-categories', 'top-filters', 'segments', 'top-pages', 'top-tags', 'top-products'])) {
                if (isset($blocks_info[$type])) {
                    $index = 0;
                    $counter = 0;
                    shuffle($blocks_info[$type]);
                    $used_words = [];
                    $tmp_geo = [];
                    if (isset($blocks_info['cities'])) {
                        $tmp_geo = $blocks_info['cities'];
                    }
                    foreach ($blocks_info[$type] as $row) {
                        $words = preg_split('#[\s\.\,]+#', $row['anchor']);
                        foreach ($words as $word) {
                            if (!isset($used_words[$word])) {
                                $used_words[$word] = 0;
                            }
                            ++$used_words[$word];
                            if ($used_words[$word] >= 3) {
                                continue 2;
                            }
                        }
                        if ('top-categories' == $type) {
                            $row['anchor'] = $this->mb_ucfirst($row['anchor'], 'utf8');
                            if (sizeof($tmp_geo) > 0) {
                                $rand_key = array_rand($tmp_geo);
                                $city_data = $tmp_geo[$rand_key];
                                unset($tmp_geo[$rand_key]);
                                $d['blocks_info'][$type][$index][] = '<span><a href="'.$row['url'].'">'.$row['anchor'].'</a></span> '.'<span city-info><a href="'.$city_data['url'].'">'.$city_data['nominative'].'</a></span>';
                            } else {
                                $d['blocks_info'][$type][$index][] = '<span><a href="'.$row['url'].'">'.$row['anchor'].'</a></span>';
                            }
                        } else {
                            $d['blocks_info'][$type][$index][] = '<a href="'.$row['url'].'">'.$row['anchor'].'</a>';
                        }
                        ++$index;
                        ++$counter;
                        if ($counter >= 32) {
                            break;
                        }
                        if ($index >= 4) {
                            $index = 0;
                        }
                    }

                    foreach ($d['blocks_info'][$type] as $index => $rows) {
                        $d['blocks_info'][$type][$index] = implode('<br/>', $rows);
                    }
                    $d['blocks_info'][$type] = '<div class="shield__footers_module_block__wrapper__row"><div class="shield__footers_module_block__wrapper__col-3 shield__footers_module_block__wrapper__col-3">'.implode('</div><div class="shield__footers_module_block__wrapper__col-3 shield__footers_module_block__wrapper__col-3">', $d['blocks_info'][$type]).'</div></div>';
                }
            } elseif ('cities' == $type) {
                if (isset($blocks_info[$type])) {
                    $index = 0;
                    $counter = 0;
                    shuffle($blocks_info[$type]);
                    foreach ($blocks_info[$type] as $row) {
                        $d['blocks_info'][$type][$index][] = '<a href="'.$row['url'].'">'.$row['nominative'].'</a>';
                        ++$index;
                        ++$counter;
                        if ($counter >= 32) {
                            break;
                        }
                        if ($index >= 4) {
                            $index = 0;
                        }
                    }
                    foreach ($d['blocks_info'][$type] as $index => $rows) {
                        $d['blocks_info'][$type][$index] = implode('<br/>', $rows);
                    }
                    $d['blocks_info'][$type] = '<div class="shield__footers_module_block__wrapper__row"><div class="shield__footers_module_block__wrapper__col-3 shield__footers_module_block__wrapper__col-3">'.implode('</div><div class="shield__footers_module_block__wrapper__col-3 shield__footers_module_block__wrapper__col-3">', $d['blocks_info'][$type]).'</div></div>';
                }
            } elseif ('faq' == $type) {
                $d['blocks_info'][$type] = [];
                if (isset($blocks_info[$type])) {
                    foreach ($blocks_info[$type] as $index => $row) {
                        $row['answer'] = preg_replace('#\n#', '<br/>', $row['answer']);
                        $d['blocks_info'][$type][] = '<li class="shield__footers_module_block__wrapper__seo-faq__item shield__footers_module_block__wrapper__card shield__footers_module_block__wrapper__shadow" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                            <div class="shield__footers_module_block__wrapper__card-header shield__footers_module_block__wrapper__py-3" data-target="#collapseQ'.$index.'" style="cursor: pointer;">
                                <span class="shield__footers_module_block__wrapper__seo-faq__question shield__footers_module_block__wrapper__m-0 shield__footers_module_block__wrapper__h6" itemprop="name">'.$row['question'].'</span>
                            </div>
                            <div class="shield__footers_module_block__wrapper__collapse card-body" id="collapseQ'.$index.'">
                                <div class="shield__footers_module_block__wrapper__seo-faq__answer shield__footers_module_block__wrapper__col-12" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                                    <div itemprop="text">
                                        <p>'.html_entity_decode($row['answer']).'</p>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    }
                }
                if (!empty($d['blocks_info'][$type])) {
                    shuffle($d['blocks_info'][$type]);
                    $d['blocks_info'][$type] = array_slice($d['blocks_info'][$type], 0, 5);
                    $d['blocks_info'][$type] = '<div class="shield__footers_module_block__wrapper__row"><div class="shield__footers_module_block__wrapper__faq seo-faq shield__footers_module_block__wrapper__col-12"><span class="shield__footers_module_block__wrapper__seo-faq__title shield__footers_module_block__wrapper__h4">Часто задаваемые вопросы</span><ul style="list-style-type : none;" aria-label="Accordion control" class="shield__footers_module_block__wrapper__seo-faq__items shield__footers_module_block__wrapper__p-0 shield__footers_module_block__wrapper__accordion" data-bui-component="Accordion" itemscope="" itemtype="https://schema.org/FAQPage">'.implode('', $d['blocks_info'][$type]).'</ul></div></div>';
                }
            } elseif ('description' == $type) {
                $d['blocks_info'][$type] = '';
                if (isset($blocks_info[$type])) {
                    $template_to_use = '';
                    if (is_array($blocks_info[$type])) {
                        foreach ($blocks_info[$type] as $template_type => $template_names) {
                            foreach ($template_names as $tpl_name) {
                                if (false !== strpos($out_html, '<!--footers_block_template:'.$tpl_name.'-->')) {
                                    $template_to_use = $tpl_name;
                                    break 2;
                                }
                            }
                        }
                        if ('' === $template_to_use) {
                            foreach ($blocks_info[$type] as $template_type => $template_names) {
                                if (false !== strpos($out_html, '<!--footers_block_template:'.$template_type.'-->')) {
                                    if (is_array($template_names)) {
                                        shuffle($template_names);
                                        $template_to_use = $template_names[0];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    $d['blocks_info'][$type] = $template_to_use;
                    if ('' !== $template_to_use) {
                        $d['blocks_info'][$type] = $template_to_use;
                        if (function_exists('seo_shield_init_generate_content')) {
                            $ss_content = seo_shield_init_generate_content([
                                'type' => $template_to_use,
                                'dynamic_markers' => $this->getDynamicMarkers($out_html),
                            ]);
                            if (class_exists('SeoShieldModule_api_generate_content')) {
                                $apiGenerateContent = new SeoShieldModule_api_generate_content();
                                $_tmp_html = $ss_content->get_start().'<!--split_footers_init-->'.$out_html;
                                $_tmp_html = $apiGenerateContent->html_out_buffer($_tmp_html);
                                $tmp_html_parts = explode('<!--split_footers_init-->', $_tmp_html);
                                $description = $tmp_html_parts[0];
                                $used_geo = [];
                                $description = $this->replaceSegmentMarkers($description, $geo_info, $segments_info, $used_geo, $geo_info_by_lemma);
                                $d['blocks_info'][$type] = $description;
                            }
                        }
                    }
                }
            } elseif ('sentences' == $type) {
                if (isset($blocks_info[$type])) {
                    $used_geo = [];
                    foreach ($blocks_info[$type] as $row) {
                        $row['sentence'] = $this->replaceSegmentMarkers($row['sentence'], $geo_info, $segments_info, $used_geo, $geo_info_by_lemma);
                        if (false !== strpos($row['sentence'], '{') || false !== strpos($row['sentence'], '}')) {
                            continue;
                        }
                        $d['blocks_info'][$type][] = '<li>'.$row['sentence'].'</li>';
                    }
                    shuffle($d['blocks_info'][$type]);
                    $d['blocks_info'][$type] = array_slice($d['blocks_info'][$type], 0, 5);
                    $d['blocks_info'][$type] = '<ul style="list-style-type: none; padding: 0px;">'.implode('', $d['blocks_info'][$type]).'</ul>';
                }
            }
        }

        return $d;
    }

    private function replaceSegmentMarkers($source, $geo_info, $segments_info, $used_geo, $geo_info_by_lemma)
    {
        $source = preg_replace_callback('#{{(.+?)}}#', function ($match) use ($geo_info, $segments_info, $used_geo, $geo_info_by_lemma) {
            $url_to_wrap = '#';
            $match[0] = preg_replace('#\s\+\s#', ' ', $match[0]);
            $match[0] = preg_replace_callback('#{geo_([^}]+)}#', function ($match) use ($geo_info, $used_geo, $geo_info_by_lemma) {
                $geo_case = $match[1];
                if (isset($geo_info[$geo_case])) {
                    uksort($geo_info_by_lemma, function () {
                        return rand() > rand();
                    });
                    foreach ($geo_info_by_lemma as $lemma => $lemma_cases) {
                        if (!isset($used_geo[$lemma]) && isset($lemma_cases[$geo_case])) {
                            $used_geo[] = $lemma;

                            return $lemma_cases[$geo_case];
                        }
                    }

                    return $geo_info[$geo_case][array_rand($geo_info[$geo_case])];
                } else {
                    return $match[0];
                }
            }, $match[0]);
            $match[0] = preg_replace_callback('#{([aA])_segment_([^}]+)}#', function ($match) use ($segments_info, &$url_to_wrap) {
                $segment = $match[2];
                $segment = mb_strtolower($segment, 'utf8');
                $ucfirst = 'A' === $match[1] ? true : false;
                if (isset($segments_info[$segment])) {
                    $segment_result = $segments_info[$segment][array_rand($segments_info[$segment])];
                    if ($ucfirst) {
                        $segment_result['anchor'] = $this->mb_ucfirst($segment_result['anchor']);
                    } else {
                        $segment_result['anchor'] = mb_strtolower($segment_result['anchor'], 'utf8');
                    }
                    $url_to_wrap = $segment_result['url'];

                    return $segment_result['anchor'];
                } else {
                    return $match[0];
                }
            }, $match[0]);
            $match[0] = preg_replace_callback('#{([pP])_segment_([^}]+)}#', function ($match) use ($segments_info) {
                $segment = $match[2];
                $segment = mb_strtolower($segment, 'utf8');
                $ucfirst = 'P' === $match[1] ? true : false;
                if (isset($segments_info[$segment])) {
                    $segment_result = $segments_info[$segment][array_rand($segments_info[$segment])];
                    if ($ucfirst) {
                        $segment_result['anchor'] = $this->mb_ucfirst($segment_result['anchor']);
                    } else {
                        $segment_result['anchor'] = mb_strtolower($segment_result['anchor'], 'utf8');
                    }

                    return $segment_result['anchor'];
                } else {
                    return $match[0];
                }
            }, $match[0]);
            $match[0] = str_replace('{{', '<a href="'.$url_to_wrap.'">', $match[0]);
            $match[0] = str_replace('}}', '</a>', $match[0]);
            $match[0] = preg_replace('#\s+([\,\.\:\!\<\;])#', '$1', $match[0]);
            $match[0] = preg_replace('#<([^\/])#', ' <$1', $match[0]);
            $match[0] = preg_replace('#\s+#', ' ', $match[0]);
            $match[0] = trim($match[0]);

            return $match[0];
        }, $source);
        $source = preg_replace_callback('#{geo_([^}]+)}#', function ($match) use ($geo_info, $used_geo, $geo_info_by_lemma) {
            $geo_case = $match[1];
            if (isset($geo_info[$geo_case])) {
                uksort($geo_info_by_lemma, function () {
                    return rand() > rand();
                });
                foreach ($geo_info_by_lemma as $lemma => $lemma_cases) {
                    if (!isset($used_geo[$lemma]) && isset($lemma_cases[$geo_case])) {
                        $used_geo[] = $lemma;

                        return $lemma_cases[$geo_case];
                    }
                }

                return $geo_info[$geo_case][array_rand($geo_info[$geo_case])];
            } else {
                return $match[0];
            }
        }, $source);
        $source = preg_replace_callback('#{([aA])_segment_([^}]+)}#', function ($match) use ($segments_info) {
            $segment = $match[2];
            $segment = mb_strtolower($segment, 'utf8');
            $ucfirst = 'A' === $match[1] ? true : false;
            if (isset($segments_info[$segment])) {
                $segment_result = $segments_info[$segment][array_rand($segments_info[$segment])];
                if ($ucfirst) {
                    $segment_result['anchor'] = $this->mb_ucfirst($segment_result['anchor']);
                } else {
                    $segment_result['anchor'] = mb_strtolower($segment_result['anchor'], 'utf8');
                }

                return '<a href="'.$segment_result['url'].'">'.$segment_result['anchor'].'</a>';
            } else {
                return $match[0];
            }
        }, $source);
        $source = preg_replace_callback('#{([pP])_segment_([^}]+)}#', function ($match) use ($segments_info) {
            $segment = $match[2];
            $segment = mb_strtolower($segment, 'utf8');
            $ucfirst = 'P' === $match[1] ? true : false;
            if (isset($segments_info[$segment])) {
                $segment_result = $segments_info[$segment][array_rand($segments_info[$segment])];
                if ($ucfirst) {
                    $segment_result['anchor'] = $this->mb_ucfirst($segment_result['anchor']);
                } else {
                    $segment_result['anchor'] = mb_strtolower($segment_result['anchor'], 'utf8');
                }

                return $segment_result['anchor'];
            } else {
                return $match[0];
            }
        }, $source);

        return $source;
    }

    private function render_template($blocks_types, $blocks_info)
    {
        $selected_type = 'top-categories';
        $html = '<div class="container shield__footers_module_block__wrapper"><div class="shield__footers_module_block__wrapper__card shield__footers_module_block__wrapper__shadow shield__footers_module_block__wrapper__mb-3"><div class="shield__footers_module_block__wrapper__card-body"><div class="shield__footers_module_block__wrapper__top shield__footers_module_block__wrapper__mb-3">';
        $i = 0;
        foreach (['top-categories' => 'ТОП Категории', 'cities' => 'Города', 'top-pages' => 'ТОП Страницы', 'top-tags' => 'ТОП Теги', 'top-products' => 'ТОП Товары', 'faq' => 'ЧаВо', 'description' => 'Описание', 'sentences' => 'Предложения'] as $id => $title) {
            if (!isset($blocks_info[$id]) || empty($blocks_info[$id])) {
                continue;
            }
            $html .= '<button data-custom-switch="'.('cities' == $id ? 'true' : 'false').'" switch-block target="#'.('cities' === $id ? 'top-categories' : $id).'" class="shield__footers_module_block__wrapper__btn shield__footers_module_block__wrapper__btn-sm shield__footers_module_block__wrapper__'.($selected_type == $id ? 'btn-success' : 'btn-light').' shield__footers_module_block__wrapper__mr-1" type="submit">'.$title.'</button>';
            ++$i;
        }
        $html .= '</div>';
        $html .= '<div class="shield__footers_module_block__wrapper__bottom">
            <div class="shield__footers_module_block__wrapper__row">
                <div class="shield__footers_module_block__wrapper__right shield__footers_module_block__wrapper__col-12 shield__footers_module_block__wrapper__col-12">';
        foreach ($blocks_types as $type => $title) {
            if ('segments' == $type || 'cities' == $type || !isset($blocks_info[$type]) || empty($blocks_info[$type])) {
                continue;
            }
        $html .= '<div block-target class="shield__footers_module_block__wrapper__card shield__footers_module_block__wrapper__shadow shield__footers_module_block__wrapper__mb-3 shield__footers_'.($type != $selected_type ? 'inactive' : 'active').'" id="'.$type.'">';
            $html .= '<div class="shield__footers_module_block__wrapper__card-body">';
            if (isset($blocks_info[$type])) {
                if (!is_array($blocks_info[$type])) {
                    $html .= $blocks_info[$type];
                }
            }
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div></div></div></div>';
        $html = preg_replace("#\n#", '', $html);
        $html = preg_replace("#\s+#", ' ', $html);
        $this->save_cached_template($html);

        return $html;
    }

    public function getDynamicMarkers($out_html)
    {
        return [
            //'{price}' => '123 UAH',
        ];
    }

    private function mb_ucfirst($string, $enc = 'UTF-8')
    {
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc).mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }

    private function addScriptsAndStyles($out_html)
    {
        $css = '<link rel="stylesheet" href="'.$GLOBALS['SEOSHIELD_CONFIG']['footers_block']['css_web_path'].'?t='.microtime(true).'">';
        $script = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['move_to_js']) && !empty($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['move_to_js'])) {
            $script .= '<script type="text/javascript">window.footers_block_move_to_js="';
            $script .= $GLOBALS['SEOSHIELD_CONFIG']['footers_block']['move_to_js'];
            $script .= '";</script>';
        }
        $script .= '<script type="text/javascript" src="'.$GLOBALS['SEOSHIELD_CONFIG']['footers_block']['js_web_path'].'"></script>';
        $out_html = str_replace('</body>', $css.'</body>', $out_html);
        $out_html = str_replace('</body>', $script.'</body>', $out_html);

        return $out_html;
    }

    private function save_cached_template($template)
    {
        $key = $GLOBALS['SEOSHIELD_CONFIG']['page_url'];
        $md5_key = md5($key);
        $dir = substr($md5_key, -2);
        $cache_file = SEOSHIELD_ROOT_PATH.'/data/footers_cache/'.$dir.'/'.$md5_key.'.cache.php';
        if (!is_dir(SEOSHIELD_ROOT_PATH.'/data/footers_cache/'.$dir.'/')) {
            mkdir(SEOSHIELD_ROOT_PATH.'/data/footers_cache/'.$dir.'/', 0777, true);
        }
        $cache_array = [];
        if (file_exists($cache_file)) {
            $cached_data = include $cache_file;
            if (is_array($cached_data)) {
                foreach ($cached_data as $k => $v) {
                    $cache_array[$k] = $v;
                }
            }
        }
        $cache_array[$key] = $template;
        file_put_contents($cache_file, '<?php return '.var_export($cache_array, true).';', LOCK_EX);
    }

    private function get_cached_template()
    {
        $template = null;
        $key = $GLOBALS['SEOSHIELD_CONFIG']['page_url'];
        $md5_key = md5($key);
        $dir = substr($md5_key, -2);
        $cache_file = SEOSHIELD_ROOT_PATH.'/data/footers_cache/'.$dir.'/'.$md5_key.'.cache.php';
        $key = $GLOBALS['SEOSHIELD_CONFIG']['page_url'];
        if (file_exists($cache_file)) {
            $cached_data = include $cache_file;

            return $cached_data[$key];
        }

        return $template;
    }

    private function get_current_h1($out_html)
    {
        if (false !== strpos($out_html, '</h1>')) {
            preg_match('#<h1[^>]*>(.*?)</h1>#', $out_html, $matches);
            if (is_array($matches) && isset($matches[1])) {
                return strip_tags($matches[1]);
            }
        }

        return '';
    }

    private function get_current_title($out_html)
    {
        if (false !== strpos($out_html, '</title>')) {
            preg_match('#<title>(.*?)</title>#', $out_html, $matches);
            if (is_array($matches) && isset($matches[1])) {
                return strip_tags($matches[1]);
            }
        }

        return '';
    }

    private function process_markers($template, $out_html)
    {
        if (false !== strpos($template, '{h1}') || false !== strpos($template, '{H1}')) {
            $h1 = $this->get_current_h1($out_html);
            $H1 = $this->mb_ucfirst($h1);
            $template = preg_replace('#\{h1\}#', $h1, $template);
            $template = preg_replace('#\{H1\}#', $H1, $template);
        }
        if (false !== strpos($template, '{title}') || false !== strpos($template, '{TITLE}')) {
            $title = $this->get_current_title($out_html);
            $TITLE = $this->mb_ucfirst($title);
            $template = preg_replace('#\{title\}#', $title, $template);
            $template = preg_replace('#\{TITLE\}#', $TITLE, $template);
        }

        return $template;
    }

    private function is_valid_url($out_html){
        if (preg_match('#<meta[^>]*?name=[\'\"]?robots[\'\"]?[^>]*?content=[\'\"]?noindex,\s*?nofollow[\'\"]?[^>]*?>#s', $out_html)){
            return false;
        }
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['404_comment']) && !empty($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['404_comment']) && strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['footers_block']['404_comment']) !== false){
            return false;
        }

        if (class_exists('RobotsTxtParser\RobotsTxtParser') && class_exists('RobotsTxtParser\RobotsTxtValidator')){
            if (!file_exists($this->robotsPath)){
                return true;
            }
            $parser = new RobotsTxtParser\RobotsTxtParser(file_get_contents($this->robotsPath));
            $url = $GLOBALS["SEOSHIELD_CONFIG"]['page_uri'];
            if (!isset($_SERVER["HTTP_USER_AGENT"]) || empty($_SERVER["HTTP_USER_AGENT"])){
                return true;
            }
            $userAgent = $_SERVER["HTTP_USER_AGENT"];

            $validator = new RobotsTxtParser\RobotsTxtValidator($parser->getRules());
            return $validator->isUrlAllow($url, $userAgent);
        }

        return true;
    }

    public function html_out_buffer($out_html)
    {
        if (!$this->is_valid_url($out_html)){
            return $out_html;
        }

        if (isset($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['to_replace']) && false !== strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['footers_block']['to_replace'])) {
            if (!isset($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['enable_cache']) || !$GLOBALS['SEOSHIELD_CONFIG']['footers_block']['enable_cache']) {
                $ready_template = null;
            } else {
                $ready_template = $this->get_cached_template();
            }
            if (null === $ready_template) {
                $d = $this->get_footers_block($out_html);
                $ready_template = $this->render_template($d['blocks_types'], $d['blocks_info']);
            }
            $ready_template = $this->process_markers($ready_template, $out_html);
            $out_html = str_replace($GLOBALS['SEOSHIELD_CONFIG']['footers_block']['to_replace'], $ready_template, $out_html);
            $out_html = $this->addScriptsAndStyles($out_html);
        }

        return $out_html;
    }
}
