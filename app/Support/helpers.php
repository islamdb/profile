<?php

use App\Models\Dictionary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Soundasleep\Html2Text;
use Stichoza\GoogleTranslate\GoogleTranslate;

if (!function_exists('route_name')) {
    /**
     * get route name by url
     *
     * @param $url
     * @return string|null
     */
    function route_name($url)
    {
        return Route::match([
            'get', 'post', 'delete', 'patch', 'put'
        ], $url)->getName();
    }
}

if (!function_exists('uuidstr')) {
    function uuidstr($delim = '-')
    {
        return str_replace('-', $delim, Str::uuid());
    }
}

if (!function_exists('query_statement')) {
    function query_statement($query, $dump = false)
    {
        $sql_str = $query->toSql();
        $bindings = $query->getBindings();

        $wrapped_str = str_replace('?', "'?'", $sql_str);

        return Str::replaceArray('?', $bindings, $wrapped_str);
    }
}

if (!function_exists('sub_query')) {
    function sub_query($query, $alias = null, $parenthesis = true)
    {
        $query = query_statement($query);
        $query = $parenthesis
            ? '(' . $query . ')'
            : $query;
        $query = is_null($alias)
            ? $query
            : $query . '`' . $alias . '`';

        return DB::raw($query);
    }
}

if (!function_exists('write_error')) {
    function write_error(Exception $exception)
    {
        if (!Schema::hasTable('errors')) {
            return null;
        }

        try {
            $userId = auth()
                ->id();
        } catch (Exception $exception) {
            $userId = null;
        }

        $errorId = DB::table('errors')
            ->insertGetId([
                'user_id' => $userId,
                'message' => $exception->getMessage(),
                'trace' => json_encode($exception->getTrace())
            ]);

        return $errorId;
    }
}

if (!function_exists('slugsql')) {
    function slugsql($field)
    {
        return "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM($field), ':', ''), ')', ''), '(', ''), ',', ''), '\\\', ''), '\/', ''), '\\\', ''), ' ? ', ''), '\'', ''), '&', ''), '!', ''), '.', ''), ' ', '-'), '--', '-'), '--', '-'), 'ą', 'a'), 'ż', 'z'), 'ź', 'z'), 'ć', 'c'), 'ń', 'n'), 'ł', 'l'), 'ó', 'o'), 'ę', 'e'), 'ś', 's'))";
    }
}

if (!function_exists('is_current_route')) {
    function is_current_route($routeName, $mustMatch = true)
    {
        if ($mustMatch) {
            return Route::currentRouteName() == $routeName;
        }

        return Str::contains(Route::currentRouteName(), $routeName);
    }
}

if (!function_exists('narrator')) {
    function narrator($text, $startReplace = '<b>', $endReplace = '</b>', $start = '[', $end = ']')
    {
        $texts = explode($start, $text);
        for ($c = 1; $c < count($texts); $c++) {
            if (Str::contains($texts[$c], $end)) {
                $texts[$c] = $startReplace . preg_replace("/$end/", $endReplace, $texts[$c], 1);
            }
        }

        return collect($texts)
            ->join('');
    }
}

if (!function_exists('lang')) {
    /**
     * get current language
     *
     * @param null $language
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|null
     */
    function lang($language = null)
    {
        if (!empty($language)) {
            session()->put('lang', $language);
        }

        if (!session()->has('lang')) {
            session()->put('lang', 'id');
        }

        $language = session('lang')[0];
        $language = (strlen($language) == 1) ? session('lang') : $language;

        return $language;
    }
}

if (!function_exists('translate')) {
    function translate(string $sentence, string $from, string $to = null, bool $forceTranslation = false)
    {
        if (empty($sentence))
            return $sentence;

        $to = empty($to)
            ? lang()
            : $to;

        if ($from == $to)
            return $sentence;

        $md5 = md5($sentence);

        $translate = Dictionary::query()
            ->select('to')
            ->where('from_id', $from)
            ->where('to_id', $to)
            ->where('from', $md5)
            ->first();

        if (empty($translate)) {
            if (strlen($sentence) > 5000 and !$forceTranslation)
                return translate('Sentence is too long to translate', 'en');

            try {
                $translate = GoogleTranslate::trans($sentence, $to, $from);

                Dictionary::query()
                    ->create([
                        'from_id' => $from,
                        'to_id' => $to,
                        'from' => $md5,
                        'to' => $translate
                    ]);

                // Dictionary::flushQueryCache();

                return $translate;
            } catch (Exception $exception) {
                write_error($exception);

                return '<i>' . $sentence . '</i>';
            }
        }

        return $translate->to;
    }
}

if (!function_exists('clean_text')) {
    function clean_text($text)
    {
        $text = preg_replace('/[^A-Za-z0-9\- ]/', '', $text);

        return $text;
    }
}

if (!function_exists('nasab')) {
    function nasab($text)
    {
        $text = str_replace('binti', 'bin', $text);

        return array_reverse(explode('bin', $text));
    }
}

if (!function_exists('badge')) {
    /**
     * badge html
     *
     * @param $text
     * @param null $type
     * @return string
     */
    function badge($text, $type = null)
    {
        if (empty($type)) {
            $badges = collect(['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark']);
            $type = $badges->random();
        }

        $type = 'badge-' . $type;

        return '<span class="badge ' . $type . '">' . $text . '</span>';
    }
}

if (!function_exists('highlight')) {
    function highlight($text, $sentence, $match = true, $clean = true, $open = '<span style="background-color: yellow">', $close = '</span>')
    {
        if (empty($sentence))
            return $text;

        $sentence = $clean
            ? clean_text($sentence)
            : $sentence;

        $words = $match
            ? [$sentence]
            : explode(' ', $sentence);

        $pattern = '#(?<=^|\W)('
            . implode('|', array_map('preg_quote', $words))
            . ')(?=$|\W)#i';

        $text = preg_replace($pattern, "$open$1$close", $text);

        return $text;
    }
}

if (!function_exists('array_to_string')) {
    /**
     * convert list to readable
     *
     * @param $array
     * @param string $splitter
     * @param string $lastSplitter
     * @return string|string[]
     */
    function array_to_string($array, $splitter = ', ', $lastSplitter = ' and ', $prefix = '', $suffix = '')
    {
        $string = implode($splitter, $array);
        $string = str_replace($splitter . last($array), $lastSplitter . last($array), $string);

        return $prefix . $string . $suffix;
    }
}

if (!function_exists('nuxt')) {
    function nuxt($basePath = '', $makeRoute = true, $param = 'zx', $optionalParam = 'zz')
    {
        $param = strtolower($param);
        $optionalParam = strtolower($optionalParam);

        $routes = [];

        collect(File::allFiles(base_path('app/Http/Livewire/' . $basePath)))
            ->filter(function ($file) {
                return $file->isFile() and $file->getExtension() == 'php';
            })
            ->each(function ($file) use ($param, $optionalParam, $basePath, &$routes, $makeRoute) {
                $params = [];
                $optionalParams = [];

                $path = str_replace('/', '\\', $basePath) . '\\' . $file->getRelativePathname();
                $path = str_replace('.php', '', $path);
                $path = str_replace('/', '\\', $path);
                $path = collect(explode('\\', $path))
                    ->map(function ($p) {
                        return Str::snake($p, '-');
                    })
                    ->join('.');

                $uri = collect(explode('\\', str_replace('/', '\\', $file->getRelativePath())))
                    ->map(function ($path) use ($param, $optionalParam, &$params, &$optionalParams) {
                        $path = Str::snake($path);

                        $exploded = explode('_', $path, 2);
                        $checkParam = strtolower($exploded[0]);

                        if ($checkParam == $param) {
                            $path = '{' . $exploded[1] . '}';
                            $params[] = $exploded[1];
                        } elseif ($checkParam == $optionalParam) {
                            $path = '{' . $exploded[1] . '?}';
                            $optionalParams[] = $exploded[1];
                        }

                        return str_replace('_', '-', $path);
                    })
                    ->join('/');
                $uri = Str::endsWith($path, 'index')
                    ? $uri
                    : $uri . '/' . Str::of($path)
                        ->explode('.')
                        ->last();
                $uri = Str::of($uri)->startsWith('/')
                    ? substr($uri, 1)
                    : $uri;

                $component = 'App\Http\Livewire\\' . $basePath . '\\' . str_replace('/', '\\', $file->getRelativePathname());
                $component = str_replace('.php', '', $component);
                $component = str_replace('/', '\\', $component);

                $name = str_replace('/', '.', $uri);
                $name = str_replace('{', '', $name);
                $name = str_replace('}', '', $name);
                $name = str_replace('?', '', $name);
                $name = empty($name)
                    ? 'home'
                    : $name;

                $routes[] = [
                    'uri' => $uri,
                    'component' => $component,
                    'path' => $path,
                    'name' => $name,
                    'params' => $params,
                    'optional_params' => $optionalParams,
                    'filepath' => $file->getRelativePathName()
                ];

                if ($makeRoute)
                    Route::get($uri, $component)
                        ->name($name);
            });

        return $routes;
    }
}

if (!function_exists('html2text')) {
    function html2text($text)
    {
        return Html2Text::convert($text, ['ignore_errors' => true]);
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $value = DB::table('settings')
            ->select('value')
            ->where('key', $key)
            ->first();

        if (empty($value))
            return $default;

        return $value->value;
    }
}
