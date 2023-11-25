<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{
    use ApiResponses;

    public function sync(){
        $translations = Translation::all();

        try {
            foreach ($translations as $translation) {
                $locales = [$translation->locale, 'en']; // Add 'en' as a locale

                foreach ($locales as $locale) {
                    $langFile = base_path('lang/' . $locale . '/' . $translation->type . '.php');

                    if (!file_exists($langFile)) {
                        File::put($langFile, '<?php return [];');
                    }

                    $translationsArray = File::getRequire($langFile);
                    $key = str_replace("\n", " ", $translation->key);
                    if($locale == 'en'){
                        $value = $key;
                    }else{
                        $value = str_replace("\n", " ", $translation->value);
                    }
                    $translationsArray[$key] = $value;

                    $content = "<?php\n\nreturn " . var_export($translationsArray, true) . ";\n";

                    File::put($langFile, $content);
                }
            }

            $message = "Success Update Translation";
            return $this->okayApiResponse([
                'message'  => $message,
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        };
    }
}
