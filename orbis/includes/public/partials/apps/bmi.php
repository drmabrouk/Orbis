<?php
/**
 * BMI Calculator Application Interface
 */
?>
<div class="orbis-app-bmi">
    <div class="orbis-bmi-container" style="max-width: 500px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: var(--orbis-shadow);">
        <h3><?php echo orbis_t('bmi_calc_title', 'Body Mass Index (BMI) Calculator', 'حاسبة مؤشر كتلة الجسم (BMI)', 'BMI'); ?></h3>
        <form id="orbis-bmi-form">
            <div class="orbis-auth-form-group">
                <label><?php echo orbis_t('height', 'Height (cm)', 'الطول (سم)', 'BMI'); ?></label>
                <input type="number" id="orbis-bmi-height" required placeholder="175">
            </div>
            <div class="orbis-auth-form-group">
                <label><?php echo orbis_t('weight', 'Weight (kg)', 'الوزن (كجم)', 'BMI'); ?></label>
                <input type="number" id="orbis-bmi-weight" required placeholder="70">
            </div>
            <div class="orbis-auth-form-group">
                <label><?php echo orbis_t('age', 'Age', 'العمر', 'BMI'); ?></label>
                <input type="number" id="orbis-bmi-age" required placeholder="25">
            </div>
            <div class="orbis-auth-form-group">
                <label><?php echo orbis_t('gender', 'Gender', 'الجنس', 'BMI'); ?></label>
                <select id="orbis-bmi-gender">
                    <option value="male"><?php echo orbis_t('male', 'Male', 'ذكر', 'BMI'); ?></option>
                    <option value="female"><?php echo orbis_t('female', 'Female', 'أنثى', 'BMI'); ?></option>
                </select>
            </div>
            <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('calculate', 'Calculate BMI', 'احسب BMI', 'BMI'); ?></button>
        </form>

        <div id="orbis-bmi-result" style="margin-top: 30px; display: none; text-align: center;">
            <div style="font-size: 24px; font-weight: 700;">BMI: <span id="orbis-bmi-val"></span></div>
            <div id="orbis-bmi-category" style="font-size: 18px; margin: 10px 0; font-weight: 600;"></div>
            <div class="orbis-bmi-meter" style="height: 10px; background: #eee; border-radius: 5px; overflow: hidden; margin-top: 15px;">
                <div id="orbis-bmi-meter-fill" style="height: 100%; width: 0; transition: width 0.5s ease;"></div>
            </div>
        </div>
    </div>

    <div class="orbis-bmi-history" style="margin-top: 40px;">
        <h4><?php echo orbis_t('bmi_history', 'Calculation History', 'سجل الحسابات', 'BMI'); ?></h4>
        <div id="orbis-bmi-history-list">
            <?php
            $history = get_user_meta( get_current_user_id(), 'orbis_bmi_history', true ) ?: array();
            if ($history):
                echo '<table class="wp-list-table widefat fixed striped"><thead><tr><th>Date</th><th>BMI</th><th>Category</th></tr></thead><tbody>';
                foreach (array_reverse($history) as $entry):
                    echo "<tr><td>{$entry['date']}</td><td>{$entry['bmi']}</td><td>{$entry['category']}</td></tr>";
                endforeach;
                echo '</tbody></table>';
            else:
                echo '<p>' . orbis_t('no_history', 'No history found.', 'لا يوجد سجل.', 'BMI') . '</p>';
            endif;
            ?>
        </div>
    </div>
</div>
