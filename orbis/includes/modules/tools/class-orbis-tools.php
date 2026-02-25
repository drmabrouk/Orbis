<?php

/**
 * The Tools module (Calculator, Clocks, File Conversion).
 *
 * @package    Orbis
 * @subpackage Orbis/includes/modules/tools
 */

class Orbis_Tools {

    public function init() {
        add_shortcode( 'orbis_calculator', array( $this, 'render_calculator' ) );
        add_shortcode( 'orbis_converter', array( $this, 'render_converter' ) );
        add_shortcode( 'orbis_clocks', array( $this, 'render_clocks' ) );
    }

    public function render_calculator() {
        ob_start();
        ?>
        <div class="orbis-calculator-ui">
            <h3><?php echo orbis_t('calculator', 'Calculator', 'الحاسبة', 'Tools'); ?></h3>
            <div id="orbis-calc-screen" style="background:#eee; padding:10px; text-align:right; font-size:20px; margin-bottom:10px; min-height:30px;">0</div>
            <div class="orbis-calc-grid" style="display:grid; grid-template-columns: repeat(4, 1fr); gap:5px;">
                <button>7</button><button>8</button><button>9</button><button>/</button>
                <button>4</button><button>5</button><button>6</button><button>*</button>
                <button>1</button><button>2</button><button>3</button><button>-</button>
                <button>0</button><button>.</button><button>=</button><button>+</button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_converter() {
        ob_start();
        ?>
        <div class="orbis-converter-ui">
            <h3><?php echo orbis_t('file_converter', 'File Converter (Word ↔ PDF)', 'محول الملفات (Word ↔ PDF)', 'Tools'); ?></h3>
            <form>
                <input type="file" name="orbis_file" accept=".doc,.docx,.pdf">
                <select name="orbis_convert_to">
                    <option value="pdf">To PDF</option>
                    <option value="word">To Word</option>
                </select>
                <button type="button" class="button"><?php echo orbis_t('convert', 'Convert', 'تحويل', 'Tools'); ?></button>
            </form>
            <p><small><?php echo orbis_t('converter_note', 'Note: Server-side conversion requires additional libraries.', 'ملاحظة: التحويل من جهة الخادم يتطلب مكتبات إضافية.', 'Tools'); ?></small></p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_clocks() {
        return '<div class="orbis-clocks"><h3>' . orbis_t('world_clocks', 'World Clocks', 'ساعات العالم', 'Tools') . '</h3><p>London: ' . gmdate('H:i') . '</p><p>New York: ' . gmdate('H:i', time() - 18000) . '</p><p>Dubai: ' . gmdate('H:i', time() + 14400) . '</p></div>';
    }
}
