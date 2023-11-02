<!-- Language -->
<div class="m-0 p-0 dropdown">
    <span class="btn bg-secondary text-dark px-2 ms-1 px-md-3 ms-md-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="--bs-bg-opacity: .1"><i class="bi bi-translate"></i>
    <span class="">
        <?php 
            switch ($templatelang) {
                case "fa":
                echo "فارسی";
                break;

                case "en":
                echo "en";
                break;

                case "tr":
                echo "Türkçe";
                break;

                case "fr":
                echo "French";
                break;

                case "du":
                echo "Deutsch ";
                break;

                case "ru":
                echo "Russian";
                break;
                
                case "br":
                echo "Brizilian";
                break;
                
                case "it":
                echo "Italian";
                break;

                default:
                echo "!!!";
            }
        ?>
    </span>
    </span>
    <div class="dropdown-menu border-1 px-4 pt-4 pb-4" style="min-width: 250px !important;">
        <p class="fs-6">{{ lang('chooselanguage') }}</p>    
        <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <select name="language" class="form-select" aria-label="Default select example">
            <option value="en" <?php if( $templatelang == 'en'){echo 'selected';} ?>> English </option>
            <option value="fa" <?php if( $templatelang == 'fa'){echo 'selected';} ?>> فارسی </option>
            <option value="tr" <?php if( $templatelang == 'tr'){echo 'selected';} ?>> Türkçe </option>
            <option value="fr" <?php if( $templatelang == 'fr'){echo 'selected';} ?>> Français </option>
            <option value="du" <?php if( $templatelang == 'du'){echo 'selected';} ?>> Deutsch </option>
            <option value="ru" <?php if( $templatelang == 'ru'){echo 'selected';} ?>> Pусский </option>
            <option value="br" <?php if( $templatelang == 'br'){echo 'selected';} ?>> Brizilian </option>
            <option value="it" <?php if( $templatelang == 'it'){echo 'selected';} ?>> Italian </option>
            </select>
            <input type="hidden" name="thisid" value="<?php echo $_GET['id'] ?? ''; ?>">
            <button class="btn btn-primary mt-3 float-end" type="submit">{{ lang('setlanguage') }}</button>
        </form>
    </div>
</div>
<!-- End Language -->