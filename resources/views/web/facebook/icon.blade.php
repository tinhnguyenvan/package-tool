@extends('view_tool::web.layout.default')
{{--https://unicode.org/Public/emoji/13.0/--}}
@section('content')
    <style>
        .label-emoji {
            font-size: 30px;
            padding: 10px;
        }

        .label-emoji:hover {
            cursor: pointer;
        }

        .form-select-icon {
            position: fixed;
        }

        .item-emoji {
            display: inline-block;
        }

        .collection-fixed {
            position: fixed;
        }
    </style>

    <div class="row list-icon-emoji">
        <div class="col s2">
            <ul class="section table-of-contents pinned table-of-contents">
                <?php
                $file = @fopen($file_name, "r");
                while (!feof($file)) {
                    $line = fgets($file);
                    if (strpos($line, '# group:') !== false) {
                        echo '<li>';
                        echo '<a href="#'.Str::slug($line).'">';
                        echo str_replace('# group:', '', $line);
                        echo '</a>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col s10">
            <div class="ads" style="margin: 10px; text-align: center">
                @if(config('app.env') == 'production')
                    <script async
                            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2133388326821128"
                            crossorigin="anonymous"></script>
                    <!-- Top 728 x 90 -->
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:728px;height:90px"
                         data-ad-client="ca-pub-2133388326821128"
                         data-ad-slot="8687434187"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                @endif
            </div>

            <?php
            $file = @fopen($file_name, "r");
            $text = '';
            $countGroup = 0;
            while (!feof($file)) {
                $line = fgets($file);
                $idBox = Str::slug($line);

                if (strpos($line, '# group:') !== false) {
                    if ($countGroup > 0) {
                        echo '</div>';
                    }
                    $countGroup++;
                    echo '<div id="'.$idBox.'" class="section scrollspy">';
                    echo '<h5>';
                    echo str_replace('# group:', '', $line);
                    echo '</h4>';
                } elseif (strpos($line, '# subgroup:') !== false) {
//                    echo '<h6 style="margin-top: 20px; font-size: 10px">';
//                    echo '<a href="'.base_url('tool/facebook-icon#'.$idBox).'">';
//                    echo '- '.trans('lang_tool::tool.'.trim(str_replace('# subgroup: ', '', $line)));
//                    echo '</a>';
//                    echo '</h6>';
                } else {
                    $icons = explode(' ;', $line);
                    $icons = preg_split('/\s+/', $icons[0]);

                    if (!empty($icons[0])) {
                        echo '<div class="item-emoji">';
                        $text = '';
                        foreach ($icons as $key => $icon) {
                            if (empty($icon)) {
                                continue;
                            }
                            $text .= '&#x'.$icon.';';
                        }
                        echo '<span data-clipboard-text="'.$text.'" onclick="M.toast({html: \'Đã copy '.$text.' \'})" title="Click copy" class="label-emoji clipboard" data-parent="" data-sub-parent="" data-text="'.$text.'">'.$text.'</span>';
                        echo '</div>';
                    }
                }
            }
            fclose($file)
            ?>
        </div>
    </div>
@endsection


