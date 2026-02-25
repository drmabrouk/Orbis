<?php
/**
 * Finance Application Interface
 */
?>
<div class="orbis-app-finance">
    <div class="orbis-finance-summary" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div class="finance-card" style="background: #e0f2fe; color: #0284c7;">
            <small><?php echo orbis_t('total_balance', 'Total Balance', 'إجمالي الرصيد', 'Finance'); ?></small>
            <h2 id="orbis-finance-balance">$0.00</h2>
        </div>
        <div class="finance-card" style="background: #dcfce7; color: #16a34a;">
            <small><?php echo orbis_t('monthly_income', 'Income (Mo)', 'الدخل (شهري)', 'Finance'); ?></small>
            <h2 id="orbis-finance-income">$0.00</h2>
        </div>
        <div class="finance-card" style="background: #fee2e2; color: #dc2626;">
            <small><?php echo orbis_t('monthly_expense', 'Expenses (Mo)', 'المصاريف (شهري)', 'Finance'); ?></small>
            <h2 id="orbis-finance-expense">$0.00</h2>
        </div>
    </div>

    <div class="orbis-app-toolbar">
        <button id="orbis-add-transaction-btn" class="button button-primary"><?php echo orbis_t('add_transaction', 'Add Transaction', 'إضافة معاملة', 'Finance'); ?></button>
    </div>

    <div class="orbis-transactions-container">
        <h4><?php echo orbis_t('recent_transactions', 'Recent Transactions', 'المعاملات الأخيرة', 'Finance'); ?></h4>
        <div id="orbis-transactions-list">
            <!-- Loaded via AJAX -->
        </div>
    </div>

    <!-- Transaction Modal -->
    <div id="orbis-transaction-modal" class="orbis-modal" style="display:none;">
        <div class="orbis-modal-content">
            <span class="orbis-close-modal">&times;</span>
            <h3><?php echo orbis_t('transaction_details', 'Transaction Details', 'تفاصيل المعاملة', 'Finance'); ?></h3>
            <form id="orbis-transaction-form">
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('type', 'Type', 'النوع', 'Finance'); ?></label>
                    <select name="trans_type" id="orbis-trans-type-field">
                        <option value="income"><?php echo orbis_t('income', 'Income', 'دخل', 'Finance'); ?></option>
                        <option value="expense"><?php echo orbis_t('expense', 'Expense', 'مصروف', 'Finance'); ?></option>
                    </select>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('amount', 'Amount', 'المبلغ', 'Finance'); ?></label>
                    <input type="number" step="0.01" name="trans_amount" required>
                </div>
                <div class="orbis-auth-form-group">
                    <label><?php echo orbis_t('description', 'Description', 'الوصف', 'Finance'); ?></label>
                    <input type="text" name="trans_desc" required>
                </div>
                <button type="submit" class="orbis-auth-submit"><?php echo orbis_t('save_transaction', 'Save Transaction', 'حفظ المعاملة', 'Finance'); ?></button>
            </form>
        </div>
    </div>
</div>
