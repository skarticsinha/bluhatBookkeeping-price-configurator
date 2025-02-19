<?php
/**
 * Plugin Name: Price Configurator
 * Description: price_configurator.
 * Version: 1.0
 * Author: Bishnu
 */
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow specific HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization, application/json"); // Allow specific headers

add_shortcode('price_configurator', 'price_configurator_shortcode');

function price_configurator_shortcode()
{
    ob_start()
        ?>
    <!-- Calculator content here -->
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        </head>
<div class="calculator-container">
    <div id="step-form"
        style="font-family: 'Inter', sans-serif; width: 100%; margin: 20px auto; border: 2px solid #e0e0e0; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;">
        <div id="step-header" style="padding: 2.25rem 2rem 0 2rem; border-bottom: 1px solid #e0e0e0;">
            <h2 id="step-title" style="font-size: 24px; font-weight: bold; margin-bottom: 4px; color: #333;">Step 1</h2>
            <p id="step-description" style="font-size: 16px; margin-bottom: 20px;">Get Your Price Quote In 3 Quick Steps.
                Just Answer These Questions and Select the Services You Need.</p>
        </div>

        <!-- Step 1 -->
        <div class="step" id="step-1" style="padding:20px; border-bottom: 1px solid #e0e0e0">
            <label for="service"
                style="font-size: 16px; font-weight: bold; color: #333; margin-bottom: 10px; display: block;">What service
                do you need?</label>
            <select id="service" name="service"
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;"
                onchange="showNextStep(); isServiceSelected(); resetData();">
                <option value="" data-price="0">Select</option>
                <option value="taxes" data-price="99">Taxes</option>
                <option value="bookkeeping" data-price="99">Bookkeeping</option>
                <option value="Taxes + Bookkeeping" data-price="99">Taxes + Bookkeeping</option>
            </select>
            <button id="nextBtn" style="display: flex;justify-content:center; margin: 2rem 0; padding: 15px 20px; background-color: #7F56D9; color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; width: 100%;">What Service You Need?</button>
        </div>

        <!-- Step TB -->
        <div class="step" id="step-tb" style="display: none; padding: 20px;">
            <h3 class="step-header">Taxes + Bookkeeping</h3>
            <div id="" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <button class="option-button" id="tax-option" onclick="nextsteptax()">Tax</button>
                <button class="option-button" id="bookkeeping-option"
                    onclick="nextstepbookkeeping()">Bookkeeping</button>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step" id="step-2" style="display: none;">
        <!--<select style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">-->
        <!--        <option >Taxes</option>-->
        <!--    </select>-->
            <div class="checklist" style="border-bottom: 1px solid #e0e0e0; padding: 0 20px 20px 20px">
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        Dedicated team of licensed tax professionals to file your income tax return on time
                    </span>
                </div>
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        Annual income tax filing for businesses (partnerships, S corps, C corps)
                    </span>
                </div>
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        Annual income tax filing for individuals (sole proprietors, contractors)
                    </span>
                </div>
            </div>

            <div style="padding: 40px 20px 0; margin-bottom: 1px solid #e0e0e0">
                <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Select additional options for your service:
                </p>
                <div id="options-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    <button class="option-button" id="taxIndividual" data-value="50"
                        onclick="selectOptionindividual(this); ifAnySelected();">Individual</button>
                    <button class="option-button" id="taxSCorp" data-value="50"
                        onclick="selectOptionScorp(this); ifAnySelected();">S
                        Corp</button>
                    <button class="option-button" id="taxCCorp" data-value="50"
                        onclick="selectOptionCcorp(this); ifAnySelected();">C
                        Corp</button>
                    <button class="option-button" id="taxPartnership" data-value="50"
                        onclick="selectOptionPartnership(this); ifAnySelected();">Partnership</button>
                    <button class="option-button" id="taxLCC" data-value="50"
                        onclick="selectOptionLCC(this); ifAnySelected();">LCC</button>
                    <button class="option-button" id="taxTrust" data-value="50"
                        onclick="selectOptionTrust(this); ifAnySelected();">Trust</button>
                </div>
                <button class="option-button"  id="taxOthers" onclick=""
                    style="display: grid; grid-template-columns: repeat(1, 1fr); max width:500px; width:100%; margin-top: 15px; margin-bottom: 20px; ">Others(Tell
                    Us)</button>
            </div>
            <!-- New Dropdown to display selected Step 2 options -->
            <!-- <select id="selected-options-dropdown" style="width:100%; margin-top:20px;">
            <option value="">Select Option</option>
        </select> -->
        </div>

        <!-- Step 3 -->
        <div class="step" id="step-3" style="display: none; padding: 20px; border-bottom: 1px solid #e0e0e0;">
            <div class="taxheader">
                <h3 class="step-header">Individual Tax Return</h3>
                <div class="crossButton" onclick="simulateClick('taxIndividual')">
                    <img src="<?php echo plugins_url('assets/x-close.svg', __FILE__); ?>" alt="">
                </div>
            </div>
            <div id="additional-options-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <button class="option-button" id="taxIndividualW2" data-value="50" onclick="selectAdditionalOption(this)">W2</button>
                <button class="option-button" id="taxIndividualBI" data-value="50" onclick="selectAdditionalOption(this)">Business
                    Income</button>
                <button class="option-button" id="taxIndividualStocks" data-value="50" onclick="selectAdditionalOption(this)">Stock / Crypto</button>
                <button class="option-button" id="taxIndividualGain" data-value="50" onclick="selectAdditionalOption(this)">Capital Gain</button>
                <button class="option-button" id="taxIndividualDependents" data-value="50" onclick="selectAdditionalOption(this)">Dependents</button>
                <button class="option-button" id="taxIndividualRentals" data-value="50" onclick="selectAdditionalOption(this)">Rental
                    Property</button>
            </div>
            <h3 style="font-size: 16px; font-weight: bold; color: #333; margin-top: 20px;">Select applicable states:</h3>
            <!-- <div class="scrollbox" id="state-checkboxes" style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; border-radius: 5px;" >
            <?php
            $states = ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"];
            foreach ($states as $state) {
                echo "<label style='display: block; margin-bottom: 5px;'><input type='checkbox' class='state-checkbox' value='$state' onclick='updateStateCount()'> $state</label>";
            }
            ?>
        </div> -->
            <!-- New state selection dropdown for Individual -->
            <div class="state-selection-container" style="display: flex; gap: 20px; margin-top: 20px;">
                <div style="flex:1;">
                    <label style="font-weight:bold;">Available States</label>
                    <select id="available-states-individual"
                        style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;"
                        onchange="addStateIndividual(this.value)">
                        <option value="">Select a state</option>
                        <?php foreach ($states as $state) {
                            echo "<option value='$state'>$state</option>";
                        } ?>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="font-weight:bold;">Selected States</label>
                    <select id="selected-states-individual" multiple style="width: 100%; height:150px;"
                        onchange="removeStateIndividual(this)">
                    </select>
                </div>
            </div>

            <!-- Check the box -->
            <label class="custom-checkbox">
                <input type="checkbox" id="subscribe" name="newsletter" value="yes">
                <span class="checkbox-design"></span>
                Need help filling past tax returns up as well? Check the box
            </label>

            <div class="result">
                <span class="billed">
                    Billed yearly
                </span>
                <span class="bold_price" id="total-priceIndividual">$0</span>
                <span class="tax-deductible">
                    100% tax deductible
                </span>
            </div>
        </div>

        <!-- Step - 5 Scorp -->
        <div class="step" id="step-5" style="display: none; padding: 20px; border-bottom: 1px solid #e0e0e0;">
            <div class="taxheader">
                <h3 class="step-header">S-corp</h3>
                <div class="crossButton" onclick="simulateClick('taxSCorp')">
                    <img src="<?php echo plugins_url('assets/x-close.svg', __FILE__); ?>" alt="">
                </div>
            </div>
            <div id="additional-options-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <button class="option-button" data-valueScorp="50" id="SCorpIncome" onclick="selectAdditionalOptionScorp(this)">Business
                    Income</button>
                <button class="option-button" data-valueScorp="50" id="SCorpGain" onclick="selectAdditionalOptionScorp(this)">Capital
                    Gain</button>
                <button class="option-button" data-valueScorp="50" id="SCorpCredits" onclick="selectAdditionalOptionScorp(this)">Business
                    Credits</button>
                <button class="option-button" data-valueScorp="50" id="SCorpProperty" onclick="selectAdditionalOptionScorp(this)">Rental
                    Property</button>
            </div>
            <h3 style="font-size: 16px; font-weight: bold; color: #333; margin-top: 20px;">Select applicable states:</h3>
            <!-- <div class="scrollbox" id="state-checkboxes-scorp" style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; border-radius: 5px;" >
            <?php
            foreach ($states as $state) {
                echo "<label style='display: block; margin-bottom: 5px;'><input type='checkbox' class='state-checkbox-scorp' value='$state' onclick='updateStateCounts()'> $state</label>";
            }
            ?>
        </div> -->
            <!-- New state selection dropdown for S-corp -->
            <div class="state-selection-container" style="display: flex; gap: 20px; margin-top: 20px;">
                <div style="flex:1;">
                    <label style="font-weight:bold;">Available States</label>
                    <select id="available-states-scorp" style="width: 100%;" onchange="addStateScorp(this.value)">
                        <option value="">Select a state</option>
                        <?php foreach ($states as $state) {
                            echo "<option value='$state'>$state</option>";
                        } ?>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="font-weight:bold;">Selected States</label>
                    <select id="selected-states-scorp" multiple style="width: 100%; height:150px;"
                        onchange="removeStateScorp(this)">
                    </select>
                </div>
            </div>

            <h3 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 15px;">No.of Members</h3>
            <input type="number" id="members" value="0" onchange="updatePriceScorp()"
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">

            <!-- Check the box -->
            <label class="custom-checkbox">
                <input type="checkbox" id="subscribe" name="newsletter" value="yes">
                <span class="checkbox-design"></span>
                Need help filling past tax returns up as well? Check the box
            </label>

            <div class="result">
                <span class="billed">
                    Billed yearly
                </span>
                <span class="bold_price" id="total-pricescorp">$0</span>
                <span class="tax-deductible">
                    100% tax deductible
                </span>
            </div>
        </div>

        <!-- Step - 6 LCC -->
        <div class="step" id="step-LCC" style="display: none; padding: 20px; border-bottom: 1px solid #e0e0e0;">
            <div class="taxheader">
                <h3 class="step-header">LCC</h3>
                <div class="crossButton" onclick="simulateClick('taxLCC')">
                    <img src="<?php echo plugins_url('assets/x-close.svg', __FILE__); ?>" alt="">
                </div>
            </div>
            <div id="additional-options-container-lcc"
                style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <button class="option-button" id="lccIncome" data-valueLcc="50" onclick="selectAdditionalOptionLcc(this)">Business
                    Income</button>
                <button class="option-button" id="lccGain" data-valueLcc="50" onclick="selectAdditionalOptionLcc(this)">Capital
                    Gain</button>
                <button class="option-button" id="lccCredits" data-valueLcc="50" onclick="selectAdditionalOptionLcc(this)">Business
                    Credits</button>
                <button class="option-button" id="lccProperty" data-valueLcc="50" onclick="selectAdditionalOptionLcc(this)">Rental
                    Property</button>
            </div>
            <h3 style="font-size: 16px; font-weight: bold; color: #333; margin-top: 20px;">Select applicable states:</h3>
            <div class="scrollbox" id="state-checkboxes-lcc"
                style="overflow-y: auto; border-top: 1px solid #ccc; border-radius: 5px;">
                <!-- <?php
                foreach ($states as $state) {
                    echo "<label style='display: block; margin-bottom: 5px;'><input type='checkbox' class='state-checkbox-lcc' value='$state' onclick='updateStateCountsLcc()'> $state</label>";
                }
                ?>
            </div> -->
                <!-- New state selection dropdown for LCC -->
                <div class="state-selection-container" style="display: flex; gap: 20px; margin-top: 20px;">
                    <div style="flex:1;">
                        <label style="font-weight:bold;">Available States</label>
                        <select id="available-states-lcc" style="width: 100%;" onchange="addStateLcc(this.value)">
                            <option value="">Select a state</option>
                            <?php foreach ($states as $state) {
                                echo "<option value='$state'>$state</option>";
                            } ?>
                        </select>
                    </div>
                    <div style="flex:1;">
                        <label style="font-weight:bold;">Selected States</label>
                        <select id="selected-states-lcc" multiple style="width: 100%; height:150px;"
                            onchange="removeStateLcc(this)">
                        </select>
                    </div>
                </div>
            </div>
            <h3 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 15px;">No.of Members</h3>
            <input type="number" id="members-lcc" value="0" onchange="updatePriceLcc()"
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
            <!-- </div> -->
            <div class="result">
                <span class="billed">
                    Billed yearly
                </span>
                <span class="bold_price" id="total-pricelcc">$0</span>
                <span class="tax-deductible">
                    100% tax deductible
                </span>
            </div>
        </div>

        <!-- Step - 7 Ccorp -->
        <div class="step" id="step-Ccorp" style="display: none; padding: 20px; border-bottom: 1px solid #e0e0e0;">
            <div class="taxheader">
                <h3 class="step-header">C-corp</h3>
                <div class="crossButton" onclick="simulateClick('taxCCorp')">
                    <img src="<?php echo plugins_url('assets/x-close.svg', __FILE__); ?>" alt="">
                </div>
            </div>
            <div id="additional-options-container-ccorp"
                style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <button class="option-button" id="CCorpIncome" data-valueCcorp="50" onclick="selectAdditionalOptionCcorp(this)">Business
                    Income</button>
                <button class="option-button" id="CCorpGain" data-valueCcorp="50" onclick="selectAdditionalOptionCcorp(this)">Capital
                    Gain</button>
                <button class="option-button" id="CCorpCredits" data-valueCcorp="50" onclick="selectAdditionalOptionCcorp(this)">Business
                    Credits</button>
                <button class="option-button" id="CCorpProperty" data-valueCcorp="50" onclick="selectAdditionalOptionCcorp(this)">Rental
                    Property</button>
            </div>
            <h3 style="font-size: 16px; font-weight: bold; color: #333; margin-top: 20px;">Select applicable states:
            </h3>
            <div class="scrollbox" id="state-checkboxes-ccorp"
                style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; border-radius: 5px;">
                <!-- <?php
                foreach ($states as $state) {
                    echo "<label style='display: block; margin-bottom: 5px;'><input type='checkbox' class='state-checkbox-ccorp' value='$state' onclick='updateStateCountsCcorp()'> $state</label>";
                }
                ?> -->
            </div>
            <!-- New state selection dropdown for C-corp -->
            <div class="state-selection-container" style="display: flex; gap: 20px; margin-top: 20px;">
                <div style="flex:1;">
                    <label style="font-weight:bold;">Available States</label>
                    <select id="available-states-ccorp" style="width: 100%;" onchange="addStateCcorp(this.value)">
                        <option value="">Select a state</option>
                        <?php foreach ($states as $state) {
                            echo "<option value='$state'>$state</option>";
                        } ?>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="font-weight:bold;">Selected States</label>
                    <select id="selected-states-ccorp" multiple style="width: 100%; height:150px;"
                        onchange="removeStateCcorp(this)">
                    </select>
                </div>
            </div>
            <h3 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 15px;">No.of Members</h3>
            <input type="number" id="members-ccorp" value="0" onchange="updatePriceCcorp()"
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">

            <div class="result">
                <span class="billed">
                    Billed yearly
                </span>
                <span class="bold_price" id="total-priceccorp">$0</span>
                <span class="tax-deductible">
                    100% tax deductible
                </span>
            </div>
        </div>

        <!-- Step - 8 Trust -->
        <div class="step" id="step-Trust" style="display: none; padding: 20px; border-bottom: 1px solid #e0e0e0;">
            <div class="taxheader">
                <h3 class="step-header">Trust</h3>
                <div class="crossButton" onclick="simulateClick('taxTrust')">
                    <img src="<?php echo plugins_url('assets/x-close.svg', __FILE__); ?>" alt="">
                </div>
            </div>
            <div id="additional-options-container-trust"
                style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <button class="option-button" id="trustIncome" data-valueTrust="50" onclick="selectAdditionalOptionTrust(this)">Business
                    Income</button>
                <button class="option-button" id="trustGain" data-valueTrust="50" onclick="selectAdditionalOptionTrust(this)">Capital
                    Gain</button>
                <button class="option-button" id="trustCredits" data-valueTrust="50" onclick="selectAdditionalOptionTrust(this)">Business
                    Credits</button>
                <button class="option-button" id="trustProperty" data-valueTrust="50" onclick="selectAdditionalOptionTrust(this)">Rental
                    Property</button>
            </div>
            <h3 style="font-size: 16px; font-weight: bold; color: #333; margin-top: 20px;">Select applicable states:
            </h3>
            <div class="scrollbox" id="state-checkboxes-trust"
                style="max-height: 150px; overflow-y: auto; border: 1px solid #ccc; border-radius: 5px;">
                <!-- <?php
                foreach ($states as $state) {
                    echo "<label style='display: block; margin-bottom: 5px;'><input type='checkbox' class='state-checkbox-trust' value='$state' onclick='updateStateCountsTrust()'> $state</label>";
                }
                ?> -->
            </div>
            <!-- New state selection dropdown for Trust -->
            <div class="state-selection-container" style="display: flex; gap: 20px; margin-top: 20px;">
                <div style="flex:1;">
                    <label style="font-weight:bold;">Available States</label>
                    <select id="available-states-trust" style="width: 100%;" onchange="addStateTrust(this.value)">
                        <option value="">Select a state</option>
                        <?php foreach ($states as $state) {
                            echo "<option value='$state'>$state</option>";
                        } ?>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="font-weight:bold;">Selected States</label>
                    <select id="selected-states-trust" multiple style="width: 100%; height:150px;"
                        onchange="removeStateTrust(this)">
                    </select>
                </div>
            </div>
            <h3 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 15px;">No.of Members</h3>
            <input type="number" id="members-trust" value="0" onchange="updatePriceTrust()"
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">

            <div class="result">
                <span class="billed">
                    Billed yearly
                </span>
                <span class="bold_price" id="total-pricetrust">$0</span>
                <span class="tax-deductible">
                    100% tax deductible
                </span>
            </div>
        </div>

        <!-- Step - 9 Partnership -->
        <div class="step" id="step-Partenership" style="display: none; padding: 20px; border-bottom: 1px solid #e0e0e0;">
            <div class="taxheader">
                <h3 class="step-header">Partnership Tax Return</h3>
                <div class="crossButton" onclick="simulateClick('taxPartnership')">
                    <img src="<?php echo plugins_url('assets/x-close.svg', __FILE__); ?>" alt="">
                </div>
            </div>

            <div class="partnershipDetails">
                <div class="partnershipDetails-wrapper">
                    <div>
                        <label for="bussinessType"
                            style="font-size: 16px; font-weight: bold; color: #333; margin-bottom: 10px; display: block;">Type
                            of Business *</label>
                        <select id="bussinessType" name="bussinessType"
                            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;"
                            onchange="isBussinessTypeSelected()">
                            <option value="" data-price="0">Type</option>
                            <option value="retail" data-price="99">Retail / E-commerce</option>
                            <option value="itService" data-price="99">IT / Software</option>
                            <option value="construction" data-price="99">Construction</option>
                            <option value="homeService" data-price="99">Home Services</option>
                            <option value="realEstate" data-price="99">Real Estate</option>
                        </select>
                    </div>
                    <div>
                        <label for="reveneu"
                            style="font-size: 16px; font-weight: bold; color: #333; margin-bottom: 10px; display: block;">Reveneu
                            *</label>
                        <select id="reveneu" name="reveneu"
                            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;"
                            onchange="isReveneuSelected()">
                            <option value="" data-price="0">Yearly Reveneu</option>
                            <option value="level1" data-price="99">0-250k</option>
                            <option value="level2" data-price="99">251k-500k</option>
                            <option value="level3" data-price="99">501k-750k</option>
                            <option value="level4" data-price="99">750k-1M</option>
                            <option value="level5" data-price="99">1M+</option>
                        </select>
                    </div>

                    <div>
                        <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Select all that is applicable:</p>
                        <div id="options-container"
                            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                            <button class="option-button" id="partnershipIncome" data-valuePartnership="50"
                                onclick="selectAdditionalOptionPartnership(this)">Business
                                Income</button>
                            <button class="option-button" id="partnershipGain" data-valuePartnership="50"
                                onclick="selectAdditionalOptionPartnership(this)">Capital
                                Gain</button>
                            <button class="option-button" id="partnershipCredits" data-valuePartnership="50"
                                onclick="selectAdditionalOptionPartnership(this)">Business
                                Credit</button>
                            <button class="option-button" id="partnershipProperty" data-valuePartnership="100"
                                onclick="selectAdditionalOptionPartnership(this)">Rental
                                Property</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="result">
                <span class="billed">
                    Billed yearly
                </span>
                <span class="bold_price" id="total-pricePartnership">$0</span>
                <span class="tax-deductible">
                    100% tax deductible
                </span>
            </div>


        </div>


        <!-- Step 2 Bookkeeping -->
        <div class="step" id="step-4" style="display: none;">
        <!--<select style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">-->
        <!--        <option >Bookkeeping</option>-->
        <!--    </select>-->
            <div class="checklist" style="border-bottom: 1px solid #e0e0e0; padding: 0 20px 40px 20px">
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        Dedicated bookkeeping experts
                    </span>
                </div>
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        Accurate monthly books and year-end tax-ready financial packages
                    </span>
                </div>
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        P&L, balance sheet and 1099 reporting
                    </span>
                </div>
                <div class="checklist-item">
                    <span>
                        <img src="<?php echo plugins_url('assets/Check_icon.png', __FILE__); ?>" alt="">
                    </span>
                    <span>
                        Unlimited communication with your bookkeeping team </span>
                </div>
            </div>

            <!-- Step 1: Select Business Category -->
    <div class="fullWidthdropdown">
        <label for="business_category" class="label">Select Business Category:</label>
        <select id="business_category" class="form-select" onchange="updateStep2()">
            <option value="">-- Select --</option>
            <option value="Retail/E-Commerce">Retail / E-Commerce</option>
            <option value="IT/Software">IT / Software</option>
            <option value="Construction">Construction</option>
            <option value="Home Services">Home Services</option>
            <option value="Real Estate">Real Estate</option>
        </select>
    </div>

    <!-- Step 2: Retail/E-Commerce -->
    <div id="step2" class="fullWidthdropdown" style="display: none;">
        <label for="revenue" class="label">Expected Revenue of the Year:</label>
        <select id="revenue" class="form-select" onchange="updatePriceBookKeeping()">
            <option value="">-- Select --</option>
            <option value="0-205k">0 - 205K</option>
            <option value="251k-500k">251K - 500K</option>
            <option value="501k-750k">501K - 750K</option>
            <option value="751k-1M">751K - 1M</option>
            <option value="1M+">1M+</option>
        </select>
        <div id="result"></div>
    </div>

    <!-- Step 3: Real Estate Options -->
    <div id="step3" class="fullWidthdropdown" style="display: none;">
        <label for="real_estate_type" class="label">Select Real Estate Business Type:</label>
        <select id="real_estate_type" class="form-select" onchange="updateRealEstateType()">
            <option value="">-- Select --</option>
            <option value="Fix and Flip">Fix and Flip</option>
            <option value="Note Investors">Note Investors</option>
        </select>

        <!-- Fix and Flip -->
        <div id="fix_flip_step" class="fullWidthdropdown" style="display: none;">
            <div style="display: flex; flex-direction: column;">                
                <label for="num_properties" class="label">Number of Properties:</label>
                <input type="number" id="num_properties" oninput="checkProperties()" min="1">
            </div>
            <div id="transactions_step" style="display: none; flex-direction: column;">
                <label for="transactions">No. of Transactions per Month:</label>
                <select id="transactions" class="form-select" onchange="updateFixFlipPrice()">
                    <option value="0-100">0 - 100</option>
                    <option value="101-200">101 - 200</option>
                    <option value="201-300">201 - 300</option>
                    <option value="301-400">301 - 400</option>
                    <option value="400+">400+</option>
                </select>
            </div>
            <div id="result_fix_flip"></div>
        </div>

        <!-- Note Investors -->
        <div id="note_investor_step" class="widthManager" style="display: none;">
            <div style="display: flex; flex-direction: column;"> 
                <label for="num_notes" class="label">Number of Notes:</label>
                <input type="number" id="num_notes" min="1">
            </div>
            <div>
                <label for="transactions_notes">No. of Transactions per Month:</label>
                <select id="transactions_notes" class="form-select" onchange="updateNoteInvestorPrice()">
                    <option value="0-100">0 - 100</option>
                    <option value="101-200">101 - 200</option>
                    <option value="201-300">201 - 300</option>
                    <option value="301-400">301 - 400</option>
                    <option value="400+">400+</option>
                </select>
            </div>
            <div id="result_note_investor"></div>
        </div>

    </div>

        <!-- taxes + bookkeeping -->
        <div class="result hidden" id="taxBookKeepingPrice" style="display: none;">
            <!-- <span class="billed">
                Billed yearly
            </span> -->
            <span class="bold_price" id="total-price">
                $0
            </span>
            <!-- <span class="tax-deductible">
                100% tax deductible
            </span> -->
        </div>

        <!-- </div> -->
        <!-- Book Call Button -->
        <div id="taxesCallButton" style="display: none; flex-direction: column; align-items: center; padding: 0 20px">
            <button
                style="display: flex;justify-content:center; margin: 2rem 0; padding: 15px 20px; background-color: #6c63ff; color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; width: 100%;">Book
                a Call to Get Started</button>
        </div>
        <!-- </div> -->
    </div>
</div>



    <script>
        
        // document.addEventListener("DOMContentLoaded", function () {
        //     const scriptURL = "https://script.google.com/macros/s/AKfycbyJxKUmzNWOkSsMZH88a9U8geQVcJ_gvpeypAIVYYbu5ZiYQ80TTg4Hh5KNwpQtXY2A/exec"; // Replace with your Google Apps Script URL
        //     const selectElements = document.querySelectorAll("service");
        //     const buttons = document.querySelectorAll(".option-button"); // Ensure your buttons have this class
        //     const resultElement = document.getElementById("result"); // Ensure this is your result display element
        
        //     function sendToGoogleSheet(data) {
        //         fetch(scriptURL, {
        //             method: "POST",
        //             body: JSON.stringify(data),
        //             headers: { "Content-Type": "application/json" },
        //         })
        //         .then(response => console.log("Data sent successfully!"))
        //         .catch(error => console.error("Error sending data:", error));
        //     }
        
        //     // Capture Select Dropdown Changes
        //     selectElements.forEach(select => {
        //         select.addEventListener("change", function () {
        //             let data = { action: "Select Changed", field: this.name, value: this.value };
        //             sendToGoogleSheet(data);
        //         });
        //     });
        
        //     // Capture Button Clicks
        //     buttons.forEach(button => {
        //         button.addEventListener("click", function () {
        //             let data = { action: "Button Clicked", button: this.innerText, value: this.getAttribute("data-value") || "" };
        //             sendToGoogleSheet(data);
        //         });
        //     });
        
        //     // Capture Calculation Result Updates
        //     const observer = new MutationObserver(() => {
        //         let data = { action: "Result Updated", result: resultElement.innerText };
        //         sendToGoogleSheet(data);
        //     });
        
        //     if (resultElement) {
        //         observer.observe(resultElement, { childList: true, subtree: true });
        //     }
        // });


        function bookCall()
        {
            window.open('https://bluhatbookkeeping.net/book-a-call/', '_blank');
        }

        function resetData() {
            // Get all elements with the class 'option-button'
            const optionButtons = document.querySelectorAll('.option-button');

            // Loop through each element
            optionButtons.forEach(button => {
                // Check if the 'selected' class is in the class list of the button
                if (button.classList.contains('selected')) {
                    // Simulate a click on the button
                    button.click();
                }
            });

            const dropdowns = document.querySelectorAll('select');
            dropdowns.forEach(dropdown => {
                if (dropdown.id === 'service') {
                // Manually dispatch the change event
                dropdown.dispatchEvent(new Event('change'));
                    return;
                }
                dropdown.selectedIndex = 0;
                // Manually dispatch the change event
                dropdown.dispatchEvent(new Event('change'));
            });

            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
                // Manually dispatch the change event
                input.dispatchEvent(new Event('change'));
            });
        }

        let totalValue = 0;
        let basePrice = 99;
        let stateCount = 1;
        let totalValueScorp = 0;
        let basePriceScorp = 400;
        // console.log ("num" + num );
        // let stateCountScorp = 1;

        function ifAnySelected() {
            const buttons = document.querySelectorAll('.option-button');
            const anySelected = Array.from(buttons).some(button => button.classList.contains('selected'));
            const step2 = document.getElementById('step-2');

            if (anySelected) {
                step2.style.paddingBottom = '20px';
                step2.style.borderBottom = '1px solid #e0e0e0';
            } else {
                step2.style.paddingBottom = '';
                step2.style.borderBottom = '';
            }
        }

        function isServiceSelected() {
            const service = document.getElementById('service');
            console.log("value: " + service.value);
            if (!(service.value === "")) {
                service.style.borderColor = "#c5a8ff";
                service.style.boxShadow = "0 0 0 3px rgba(211, 194, 247, 0.7)";
            }
            else {
                service.style.borderColor = "#ccc";
                service.style.boxShadow = "";
            }
        }

        function isBussinessTypeSelected() {
            const service = document.getElementById('bussinessType');
            if (!(service.value === "")) {
                service.style.borderColor = "#c5a8ff";
                service.style.boxShadow = "0 0 0 3px rgba(211, 194, 247, 0.7)";
            }
            else {
                service.style.borderColor = "#ccc";
                service.style.boxShadow = "";
            }
        }

        function isReveneuSelected() {
            const rev = document.getElementById('reveneu');
            if (!(rev.value === "")) {
                rev.style.borderColor = "#c5a8ff";
                rev.style.boxShadow = "0 0 0 3px rgba(211, 194, 247, 0.7)";
            }
            else {
                rev.style.borderColor = "#ccc";
                rev.style.boxShadow = "";
            }
        }

        function hideEachTaxes()
        {
            const individual = document.getElementById("step-3");
            const scorp = document.getElementById("step-5");
            const llc = document.getElementById("step-LCC");
            const ccorp = document.getElementById("step-Ccorp");
            const trust = document.getElementById("step-Trust");
            const partner = document.getElementById("step-Partenership");

            individual.style.display = 'none';
            scorp.style.display = 'none';
            llc.style.display = 'none';
            ccorp.style.display = 'none';
            trust.style.display = 'none';
            partner.style.display = 'none';
        }

        function showNextStep() {
            const service = document.getElementById('service').value;
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const step3 = document.getElementById('step-3');
            const step4 = document.getElementById('step-4');
            const step5 = document.getElementById('step-5');
            const steptb = document.getElementById('step-tb')
            const stepTitle = document.getElementById('step-title');
            const stepDescription = document.getElementById('step-description');
            const taxesCallButton = document.getElementById("taxesCallButton");
            const taxBookKeepingPrice = document.getElementById("taxBookKeepingPrice")
            let nextButton = document.getElementById("nextBtn");



            if (service === 'taxes') {
                // step1.style.display = 'none';
                nextButton.style.display = "none";
                step1.style.border = 'none';
                // step1.style.padding-bottom = '0';
                step2.style.display = 'block';
                steptb.style.display = 'none';
                step4.style.display = 'none';
                stepTitle.innerText = 'Step 2';
                // stepDescription.innerText = 'Select additional options for your service:';
                taxesCallButton.style.display = 'flex';
                taxBookKeepingPrice.style.display = 'none';
            } else if (service === 'bookkeeping') {
                // step1.style.display = 'none';
                nextButton.style.display = "none";
                step4.style.display = 'block';
                step2.style.display = 'none';
                steptb.style.display = 'none';
                stepTitle.innerText = 'Step 2';
                // stepDescription.innerText = 'Step 2';
                taxesCallButton.style.display = 'none';
                taxBookKeepingPrice.style.display = 'none';
                hideEachTaxes();
            } else if (service === 'Taxes + Bookkeeping') {
                // step1.style.display = 'none';
                nextButton.style.display = "none";
                step4.style.display = 'none';
                step2.style.display = 'none';
                steptb.style.display = 'block';
                stepTitle.innerText = 'Step 2';
                // stepDescription.innerText = 'Step 2';
                taxesCallButton.style.display = 'none';
                taxBookKeepingPrice.style.display = 'flex';
                hideEachTaxes();
            } else {
                nextButton.style.display = "block";
                step2.style.display = 'none';
                steptb.style.display = 'none';
                step4.style.display = 'none';
                stepTitle.innerText = 'Step 1';
                stepDescription.innerText = 'Get Your Price Quote In 3 Quick Steps. Just Answer These Questions and Select the Services You Need.';
                taxesCallButton.style.display = 'none';
                taxBookKeepingPrice.style.display = 'none';
            }

            // updatePrice();
        }


        function selectOptionindividual(individual) {
            // const value = button.getAttribute('data-value');
            // if (selectedOptions.includes(value)) {
            //     selectedOptions = selectedOptions.filter(opt => opt !== value);
            //     button.classList.remove('selected');
            // } else {
            //     selectedOptions.push(value);
            //     button.classList.add('selected');
            // }
            if (individual.classList.contains('selected')) {
                individual.classList.remove('selected');
                document.getElementById('step-3').style.display = 'none';
                // Optionally, you could hide step-3 if no option remains selected
            } else {
                individual.classList.add('selected');
                document.getElementById('step-3').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                // updatePrice();
            }
            updateStep2Dropdown();
        }

        function selectOptionScorp(Scorp) {
            if (Scorp.classList.contains('selected')) {
                Scorp.classList.remove('selected');
                document.getElementById('step-5').style.display = 'none';
            } else {
                Scorp.classList.add('selected');
                document.getElementById('step-5').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                // updatePrice();
            }
            updateStep2Dropdown();
        }

        function selectOptionLCC(Lcc) {
            if (Lcc.classList.contains('selected')) {
                Lcc.classList.remove('selected');
                document.getElementById('step-LCC').style.display = 'none';
            } else {
                Lcc.classList.add('selected');
                document.getElementById('step-LCC').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                // updatePriceLcc();
            }
            updateStep2Dropdown();
        }

        function selectOptionCcorp(Ccorp) {
            if (Ccorp.classList.contains('selected')) {
                Ccorp.classList.remove('selected');
                document.getElementById('step-Ccorp').style.display = 'none';
            } else {
                Ccorp.classList.add('selected');
                document.getElementById('step-Ccorp').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                // updatePriceCcorp();
            }
            updateStep2Dropdown();
        }

        function selectOptionTrust(Trust) {
            if (Trust.classList.contains('selected')) {
                Trust.classList.remove('selected');
                document.getElementById('step-Trust').style.display = 'none';
            } else {
                Trust.classList.add('selected');
                document.getElementById('step-Trust').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                // updatePriceTrust();
            }
            updateStep2Dropdown();
        }

        function selectOptionPartnership(Partnership) {
            if (Partnership.classList.contains('selected')) {
                Partnership.classList.remove('selected');
                document.getElementById('step-Partenership').style.display = 'none';
            } else {
                Partnership.classList.add('selected');
                // No corresponding step defined for Partnership
                document.getElementById('step-Partenership').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                // updatePrice();
            }
            updateStep2Dropdown();
        }



        // function selectAdditionalOption(button) {
        //     const value = button.getAttribute('data-value');
        //     if (additionalOptions.includes(value)) {
        //         additionalOptions = additionalOptions.filter(opt => opt !== value);
        //         button.classList.remove('selected');
        //     } else {
        //         additionalOptions.push(value);
        //         button.classList.add('selected');
        //     }
        //     updatePrice();
        // }
        // Calculate Total value of selected buttons 
        function selectAdditionalOption(button) {
            const isSelected = button.classList.contains('selected');
            const value = parseInt(button.getAttribute('data-value'), 10);

            if (isSelected) {
                totalValue -= value;
                button.classList.remove('selected');
            } else {
                totalValue += value;
                button.classList.add('selected');
            }
            updatePrice();

        }
        // Scorp
        function selectAdditionalOptionScorp(button) {
            const isSelectedScorp = button.classList.contains('selected');
            const valueScorp = parseInt(button.getAttribute('data-valueScorp'), 10);

            if (isSelectedScorp) {
                totalValueScorp -= valueScorp;
                button.classList.remove('selected');
            } else {
                totalValueScorp += valueScorp;
                button.classList.add('selected');
            }
            updatePriceScorp();

        }


        // Count selected states
        function updateStateCount() {
            const stateCheckboxes = document.querySelectorAll('.state-checkbox');
            stateCount = Array.from(stateCheckboxes).filter(checkbox => checkbox.checked).length || 1;
            updatePrice();
        }


        // function updateStateCounts() {
        //     let stateCheckboxes = document.querySelectorAll("#state-checkboxes-scorp .state-checkbox-scorp").length;
        //     stateCount = Array.from(stateCheckboxes).filter(checkbox => checkbox.checked).length || 1;
        //     console.log(stateCheckboxes);
        //     updatePriceScorp();
        // }

        // document.querySelectorAll("#state-checkboxes-scorp .state-checkbox-scorp").forEach(checkbox => {
        //     checkbox.addEventListener("change", updateStateCounts);
        // });



        let checkedStatesCount = 0; // Variable to store the checked count

        function updateStateCounts() {
            // Select all checkboxes
            let checkboxes = document.querySelectorAll('.state-checkbox-scorp');
            // Count checked checkboxes
            checkedStatesCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
            console.log("checked state count" + checkedStatesCount)
            updatePriceScorp()
        }

        // --- New Variables and Functions for LCC ---
        let totalValueLcc = 0;
        let basePriceLcc = 400;
        let checkedStatesCountLcc = 0;

        function selectAdditionalOptionLcc(button) {
            const isSelected = button.classList.contains('selected');
            const value = parseInt(button.getAttribute('data-valueLcc'), 10);

            if (isSelected) {
                totalValueLcc -= value;
                button.classList.remove('selected');
            } else {
                totalValueLcc += value;
                button.classList.add('selected');
            }
            updatePriceLcc();
        }

        function updateStateCountsLcc() {
            let checkboxes = document.querySelectorAll('.state-checkbox-lcc');
            checkedStatesCountLcc = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
            updatePriceLcc();
        }

        function updatePriceLcc() {
            let num = parseFloat(document.getElementById('members-lcc').value) || 0; // Default to 0 if empty/invalid

            if (num > 2) {
                num = (num - 2) * 100;
            } else {
                num = 0;
            }

            let extraStateChargeLcc = (checkedStatesCountLcc > 1 ? (checkedStatesCountLcc - 1) * 100 : 0);

            let finalPriceLcc = basePriceLcc + totalValueLcc + num + extraStateChargeLcc;
            finalPriceLcc = Math.round(finalPriceLcc);
            document.getElementById("total-pricelcc").innerText = `$${finalPriceLcc}`;
            updatePriceTB();
        }

        // --- New Variables and Functions for Ccorp ---
        let totalValueCcorp = 0;
        let basePriceCcorp = 400;
        let checkedStatesCountCcorp = 0;

        function selectAdditionalOptionCcorp(button) {
            const isSelected = button.classList.contains('selected');
            const value = parseInt(button.getAttribute('data-valueCcorp'), 10);

            if (isSelected) {
                totalValueCcorp -= value;
                button.classList.remove('selected');
            } else {
                totalValueCcorp += value;
                button.classList.add('selected');
            }
            updatePriceCcorp();
        }

        function updateStateCountsCcorp() {
            let checkboxes = document.querySelectorAll('.state-checkbox-ccorp');
            checkedStatesCountCcorp = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
            updatePriceCcorp();
        }

        function updatePriceCcorp() {
            let num = parseFloat(document.getElementById('members-ccorp').value) || 0;
            if (num > 2) {
                num = (num - 2) * 100;
            } else {
                num = 0;
            }
            let extraStateChargeCcorp = (checkedStatesCountCcorp > 1 ? (checkedStatesCountCcorp - 1) * 100 : 0);
            let finalPriceCcorp = basePriceCcorp + totalValueCcorp + num + extraStateChargeCcorp;
            finalPriceCcorp = Math.round(finalPriceCcorp);
            document.getElementById("total-priceccorp").innerText = `$${finalPriceCcorp}`;
            updatePriceTB();
        }

        // --- New Variables and Functions for Trust ---
        let totalValueTrust = 0;
        let basePriceTrust = 400;
        let checkedStatesCountTrust = 0;

        function selectAdditionalOptionTrust(button) {
            const isSelected = button.classList.contains('selected');
            const value = parseInt(button.getAttribute('data-valueTrust'), 10);

            if (isSelected) {
                totalValueTrust -= value;
                button.classList.remove('selected');
            } else {
                totalValueTrust += value;
                button.classList.add('selected');
            }
            updatePriceTrust();
        }

        function updateStateCountsTrust() {
            let checkboxes = document.querySelectorAll('.state-checkbox-trust');
            checkedStatesCountTrust = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
            updatePriceTrust();
        }

        function updatePriceTrust() {
            let num = parseFloat(document.getElementById('members-trust').value) || 0;
            if (num > 2) {
                num = (num - 2) * 100;
            } else {
                num = 0;
            }
            let extraStateChargeTrust = (checkedStatesCountTrust > 1 ? (checkedStatesCountTrust - 1) * 100 : 0);
            let finalPriceTrust = basePriceTrust + totalValueTrust + num + extraStateChargeTrust;
            finalPriceTrust = Math.round(finalPriceTrust);
            document.getElementById("total-pricetrust").innerText = `$${finalPriceTrust}`;
            updatePriceTB();
        }

        // --- New Variables and Functions for Partnership ---  
        let totalValuePartnership = 0;
        let basePricePartnership = 400;
        let checkedStatesCountPartnership = 0;

        function selectAdditionalOptionPartnership(button) {
            const isSelected = button.classList.contains('selected');
            const value = parseInt(button.getAttribute('data-valuePartnership'), 10);

            if (isSelected) {
                totalValuePartnership -= value;
                button.classList.remove('selected');
            } else {
                totalValuePartnership += value;
                button.classList.add('selected');
            }
            updatePricePartnership();
        }

        function updatePricePartnership() {
            let num = parseFloat(document.getElementById('members-ccorp').value) || 0;
            if (num > 2) {
                num = (num - 2) * 100;
            } else {
                num = 0;
            }
            let extraStateChargeCcorp = (checkedStatesCountCcorp > 1 ? (checkedStatesCountCcorp - 1) * 100 : 0);
            let finalPriceCcorp = basePriceCcorp + totalValueCcorp + num + extraStateChargeCcorp;
            finalPriceCcorp = Math.round(finalPriceCcorp);
            document.getElementById("total-pricePartnership").innerText = `$${finalPriceCcorp}`;
            updatePriceTB();
        }

        // New function to update the dropdown in Step 2 with selected options
        function updateStep2Dropdown() {
            let dropdown = document.getElementById("selected-options-dropdown");
            if (dropdown) {
                dropdown.innerHTML = ''; // Clear existing options
            }
            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.text = "Select Option";
            if (dropdown) {
                dropdown.appendChild(defaultOption);
            }
            var buttons = document.querySelectorAll("#options-container .option-button");
            buttons.forEach(function (btn) {
                if (btn.classList.contains("selected")) {
                    var opt = document.createElement("option");
                    opt.value = btn.innerText;
                    opt.text = btn.innerText;
                    if (dropdown) {
                        dropdown.appendChild(opt);
                    }
                }
            });
        }

        // --- New functions for state selection dropdowns for Individual ---
        function addStateIndividual(state) {
            if (state === "") return;
            var selectedDropdown = document.getElementById("selected-states-individual");
            // Check if already added
            for (var i = 0; i < selectedDropdown.options.length; i++) {
                if (selectedDropdown.options[i].value === state) return;
            }
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            selectedDropdown.add(option);
            updateStateCountIndividual();
        }

        function removeStateIndividual(dropdown) {
            // This function is triggered when selection changes (if user deselects)
            updateStateCountIndividual();
        }

        function updateStateCountIndividual() {
            var selectedDropdown = document.getElementById("selected-states-individual");
            var count = selectedDropdown.options.length;
            // For Individual, if no state is selected, we default to 1 (as per original logic)
            stateCount = (count > 0 ? count : 1);
            updatePrice();
        }

        // --- New functions for state selection dropdowns for S-corp ---
        function addStateScorp(state) {
            if (state === "") return;
            var selectedDropdown = document.getElementById("selected-states-scorp");
            for (var i = 0; i < selectedDropdown.options.length; i++) {
                if (selectedDropdown.options[i].value === state) return;
            }
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            selectedDropdown.add(option);
            updateStateCountScorp();
        }

        function removeStateScorp(dropdown) {
            updateStateCountScorp();
        }

        function updateStateCountScorp() {
            var selectedDropdown = document.getElementById("selected-states-scorp");
            var count = selectedDropdown.options.length;
            // For S-corp, update checkedStatesCount based on the new dropdown
            checkedStatesCount = (count > 0 ? count : 1);
            updatePriceScorp();
        }

        // --- New functions for state selection dropdowns for LCC ---
        function addStateLcc(state) {
            if (state === "") return;
            var selectedDropdown = document.getElementById("selected-states-lcc");
            for (var i = 0; i < selectedDropdown.options.length; i++) {
                if (selectedDropdown.options[i].value === state) return;
            }
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            selectedDropdown.add(option);
            updateStateCountLccNew();
        }

        function removeStateLcc(dropdown) {
            updateStateCountLccNew();
        }

        function updateStateCountLccNew() {
            var selectedDropdown = document.getElementById("selected-states-lcc");
            var count = selectedDropdown.options.length;
            checkedStatesCountLcc = (count > 0 ? count : 0);
            updatePriceLcc();
        }

        // --- New functions for state selection dropdowns for C-corp ---
        function addStateCcorp(state) {
            if (state === "") return;
            var selectedDropdown = document.getElementById("selected-states-ccorp");
            for (var i = 0; i < selectedDropdown.options.length; i++) {
                if (selectedDropdown.options[i].value === state) return;
            }
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            selectedDropdown.add(option);
            updateStateCountCcorpNew();
        }

        function removeStateCcorp(dropdown) {
            updateStateCountCcorpNew();
        }

        function updateStateCountCcorpNew() {
            var selectedDropdown = document.getElementById("selected-states-ccorp");
            var count = selectedDropdown.options.length;
            checkedStatesCountCcorp = (count > 0 ? count : 0);
            updatePriceCcorp();
        }

        // --- New functions for state selection dropdowns for Trust ---
        function addStateTrust(state) {
            if (state === "") return;
            var selectedDropdown = document.getElementById("selected-states-trust");
            for (var i = 0; i < selectedDropdown.options.length; i++) {
                if (selectedDropdown.options[i].value === state) return;
            }
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            selectedDropdown.add(option);
            updateStateCountTrustNew();
        }

        function removeStateTrust(dropdown) {
            updateStateCountTrustNew();
        }

        function updateStateCountTrustNew() {
            var selectedDropdown = document.getElementById("selected-states-trust");
            var count = selectedDropdown.options.length;
            checkedStatesCountTrust = (count > 0 ? count : 0);
            updatePriceTrust();
        }

        // Calculate and update price
        function updatePrice() {
            const extraStateCharge = (stateCount - 1) * 60; // State charge beyond the first
            var finalPrice = 0;
            // const optionTotal = selectedOptions.reduce((sum, val) => sum + val, 0); // Sum of selected options
            if(!(totalValue === 0))
            {
                finalPrice = Math.max(basePrice, totalValue) + extraStateCharge; // Final price logic
            }

            // Update displayed price
            document.getElementById("total-priceIndividual").innerText = '$' + finalPrice;
            updatePriceTB();
        }

        // function updatePriceScorp(){
        //     let num = parseFloat(document.getElementById('members').value);
        //     console.log("num: " + num );
        //     // const extraStateCharge = (stateCount - 1) * 100;
        //     console.log(`basePrice: ` + basePriceScorp + `   totalValueScorp: ` + totalValueScorp + `num: ` +num );
        //     const finalPriceScorp = basePriceScorp + totalValueScorp + num ;
        //     console.log("final: " + finalPriceScorp);
        //     document.getElementById("total-pricescorp").innerText = `$${finalPriceScorp}`;
        // }
        function updatePriceScorp() {
            let num = parseFloat(document.getElementById('members').value) || 0; // Default to 0 if empty/invalid

            console.log("Original num: " + num);

            if (num > 2) {
                num = (num - 2) * 100;
            } else {
                num = 0;
            }

            console.log("Processed num: " + num);

            if (typeof basePriceScorp === 'undefined' || typeof totalValueScorp === 'undefined') {
                console.error("Error: basePriceScorp or totalValueScorp is undefined.");
                return;
            }

            console.log(`basePrice: ${basePriceScorp}, totalValueScorp: ${totalValueScorp}, num: ${num}`);

            let extraStateChargeScorp = (checkedStatesCount > 1 ? (checkedStatesCount - 1) * 100 : 0);
            let finalPriceScorp = basePriceScorp + totalValueScorp + num + extraStateChargeScorp;
            finalPriceScorp = Math.round(finalPriceScorp);
            console.log("final: " + finalPriceScorp);

            document.getElementById("total-pricescorp").innerText = `$${finalPriceScorp}`;

            updatePriceTB();
        }


        // --- bookkeeping ---
        function updateStep2() {
            let category = document.getElementById("business_category").value;
            let step2Div = document.getElementById("step2");
            let step3Div = document.getElementById("step3");
            let resultDiv = document.getElementById("result");
            step2Div.style.display = "none";
            step3Div.style.display = "none";
            resultDiv.innerHTML = "";

            if (category === "Retail/E-Commerce") {
                step2Div.style.display = "flex";
            } else if (category === "Real Estate") {
                step3Div.style.display = "flex";
            }
        }

        function updatePriceBookKeeping() {
            let revenue = document.getElementById("revenue").value;
            let resultDiv = document.getElementById("result");

            let pricing = {
                "0-205k": 99,
                "251k-500k": 149,
                "501k-750k": 199,
                "751k-1M": 249
            };

            if (revenue === "1M+") {
                resultDiv.innerHTML = '<button onclick="bookCall()">Book a Call</button>';
            } else {
                resultDiv.innerHTML = '<div class="result hidden" id="taxBookKeepingPrice" style="display: flex;">'+
            '<span class="billed"> Billed yearly </span>' + 
            '<span class="bold_price" id="total-price">$' + pricing[revenue] + '</span>' + 
            '<span class="tax-deductible">100% tax deductible</span> </div>';
            }
        }

        function updateRealEstateType() {
            let type = document.getElementById("real_estate_type").value;
            document.getElementById("fix_flip_step").style.display = "none";
            document.getElementById("note_investor_step").style.display = "none";

            if (type === "Fix and Flip") {
                document.getElementById("fix_flip_step").style.display = "flex";
            } else if (type === "Note Investors") {
                document.getElementById("note_investor_step").style.display = "block";
            }
        }

        function checkProperties() {
            let numProperties = document.getElementById("num_properties").value;
            let transactionsDiv = document.getElementById("transactions_step");
            let resultDiv = document.getElementById("result_fix_flip");

            if (numProperties > 5) {
                transactionsDiv.style.display = "none";
                resultDiv.innerHTML = '<button onclick="bookCall()">Book a Call</button>';
            } else {
                transactionsDiv.style.display = "block";
                resultDiv.innerHTML = "";
            }
        }

        function updateFixFlipPrice() {
            let transactions = document.getElementById("transactions").value;
            let resultDiv = document.getElementById("result_fix_flip");

            let pricing = {
                "0-100": 99,
                "101-200": 149,
                "201-300": 199,
                "301-400": 249
            };

            if (transactions === "400+") {
                resultDiv.innerHTML = '<button onclick="bookCall()">Book a Call</button>';
            } else {
                resultDiv.innerHTML = '<div class="result hidden" id="taxBookKeepingPrice" style="display: flex;">'+
            '<span class="billed"> Billed yearly </span>' + 
            '<span class="bold_price" id="total-price">$' + pricing[transactions] + '</span>' + 
            '<span class="tax-deductible">100% tax deductible</span> </div>';
           }
        }

        function updateNoteInvestorPrice() {
            let numNotes = document.getElementById("num_notes").value;
            let transactions = document.getElementById("transactions_notes").value;
            let resultDiv = document.getElementById("result_note_investor");

            let pricing = {
                "0-100": 99,
                "101-200": 149,
                "201-300": 199,
                "301-400": 249
            };

            let extraCharge = numNotes > 5 ? (numNotes - 5) * 15 : 0;

            if (transactions === "400+") {
                resultDiv.innerHTML = '<button onclick="bookCall()">Book a Call</button>';
            } else {
                let total = pricing[transactions] + extraCharge;
                resultDiv.innerHTML = '<div class="result hidden" id="taxBookKeepingPrice" style="display: flex;">'+
            '<span class="billed"> Billed yearly </span>' + 
            '<span class="bold_price" id="total-price">$' + total + '</span>' + 
            '<span class="tax-deductible">100% tax deductible</span> </div>';
           }
        }


        function bookKeepingBusinessSelected() {
            const business = document.getElementById("businessCategory");

            if (!(business.value === "")) {
                business.style.borderColor = "#c5a8ff";
                business.style.boxShadow = "0 0 0 3px rgba(211, 194, 247, 0.7)";
            }
            else {
                business.style.borderColor = "#ccc";
                business.style.boxShadow = "";
            }
        }

        function bookKeepingRevenuSelected() {
            const reveneu = document.getElementById("expectedRevenue");

            if (!(reveneu.value === "")) {
                reveneu.style.borderColor = "#c5a8ff";
                reveneu.style.boxShadow = "0 0 0 3px rgba(211, 194, 247, 0.7)";
                document.getElementById("BookKeepingPrice").style.display = "flex";
            }
            else {
                reveneu.style.borderColor = "#ccc";
                reveneu.style.boxShadow = "";
                document.getElementById("BookKeepingPrice").style.display = "none";
            }
        }

        // For Taxes+Bookkeeping
        function nextsteptax() {
            const Tax = document.getElementById("tax-option");
            console.log("Tax ClassList: " + Tax.classList);
            if (Tax.classList.contains('selected')) {
                Tax.classList.remove('selected');
                document.getElementById('step-2').style.display = 'none';
            } else {
                Tax.classList.add("selected");

                // removes Bookkeeping section when taxes is selected
                document.getElementById("bookkeeping-option").classList.remove('selected');
                document.getElementById('step-4').style.display = 'none';

                document.getElementById('step-2').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                updatePriceTB();
            }
            updateStep2Dropdown();
        }

        function nextstepbookkeeping() {
            const Bookkeeping = document.getElementById("bookkeeping-option");
            console.log("BookKeeping ClassList: " + Bookkeeping.classList);
            if (Bookkeeping.classList.contains('selected')) {
                Bookkeeping.classList.remove('selected');
                document.getElementById('step-4').style.display = 'none';
            } else {
                Bookkeeping.classList.add("selected");

                // removes Taxes section when bookKeeping is selected
                document.getElementById("tax-option").classList.remove('selected');
                document.getElementById('step-2').style.display = 'none';
                hideEachTaxes();

                document.getElementById('step-4').style.display = 'block';
                document.getElementById('step-title').innerText = 'Step 3';
                document.getElementById('step-description').innerText = 'Choose additional details:';
                updatePriceTB();
            }
            updateStep2Dropdown();

        }

        function updatePriceTB() {
            var totalTax = 0;
            var totalBookkeeping = 0;
            var actualPrice = 0;
            var Discount = 0;

            const taxIndividual = document.getElementById("taxIndividual");
            const taxSCorp = document.getElementById("taxSCorp");
            const taxCCorp = document.getElementById("taxCCorp");
            const taxPartnership = document.getElementById("taxPartnership");
            const taxLCC = document.getElementById("taxLCC");
            const taxTrust = document.getElementById("taxTrust");

            if (taxIndividual.classList.contains('selected')) {
                totalTax += parseInt(document.getElementById('total-priceIndividual').innerText.slice(1));
            }
            if (taxSCorp.classList.contains('selected')) {
                totalTax += parseInt(document.getElementById('total-pricescorp').innerText.slice(1));
            }
            if (taxCCorp.classList.contains('selected')) {
                totalTax += parseInt(document.getElementById('total-priceccorp').innerText.slice(1));
            }
            if (taxPartnership.classList.contains('selected')) {
                totalTax += parseInt(document.getElementById('total-pricePartnership').innerText.slice(1));
            }
            if (taxLCC.classList.contains('selected')) {
                totalTax += parseInt(document.getElementById('total-pricelcc').innerText.slice(1));
            }
            if (taxTrust.classList.contains('selected')) {
                totalTax += parseInt(document.getElementById('total-pricetrust').innerText.slice(1));
            }

            const bookKeepingCategory = document.getElementById("business_category");
            const retailRevenu = document.getElementById("revenue");

            if (bookKeepingCategory.value === "Retail")
            {
                if(!retailRevenu.value == '')
                {
                    totalBookkeeping += parseInt(document.getElementById('total-BookKeepingPrice').innerText.slice(1));
                }
            }


            // console.log("~~~~~~~~~~~~~~~~~~~");
            // console.log("indivisual: " + document.getElementById('total-priceIndividual').innerText);
            // console.log("scorp: " + document.getElementById('total-pricescorp').innerText);
            // console.log("ccorp: " + document.getElementById('total-priceccorp').innerText);
            // console.log("partner: " + document.getElementById('total-pricePartnership').innerText);
            // console.log("llc: " + document.getElementById('total-pricelcc').innerText);
            // console.log("trust: " + document.getElementById('total-pricetrust').innerText);
            // console.log(" ");
            // console.log("totalTax: " + totalTax);
            // console.log("totalBookkeeping: " + totalBookkeeping);

            
            actualPrice = totalTax + totalBookkeeping;
            Discount = Math.min(((actualPrice)/10), ((Math.min (totalTax,totalBookkeeping))/2));
            document.getElementById("total-price").innerText = '$' + (actualPrice - Discount);

            // console.log("actualPrice: " + actualPrice);
            // console.log("actualPrice/10: " + actualPrice/10);
            // console.log("actualPrice/2: " + Math.min(total));
        }

        function simulateClick(id)
        {
            document.getElementById(id).click();
        }
        
        
        
        
        // ---------------------------------------------------------
        
        // Function to return the states as a string from the element with the given ID
        function getStates(id) {
            const selectedStatesElement = document.getElementById(id);
            
            // Check if the element exists
            if (selectedStatesElement) {
                // If the states are child elements of the given ID, loop through them and get their content
                const states = selectedStatesElement.children;
                if (states.length > 0) {
                    let stateNames = [];
                    for (let i = 0; i < states.length; i++) {
                        // Get the text content of each child element and add it to the array
                        stateNames.push(states[i].textContent || states[i].innerText);
                    }
                    // Return the states as a single comma-separated string
                    return stateNames.join(', ');
                } else {
                    return 'No states Selected.';
                }
            } else {
                return `Element with id "${id}" not found.`;
            }
        }
        
        // Declare a global variable for the userId adn scriptURL
        let globalUserId = null;
        // let scriptURL = 'https://cors-anywhere.herokuapp.com/script.google.com/macros/s/AKfycbwJkYQSoB4oWnbq_3Pm6LZAMHRT42mLXtqaftQvidWQN3gYfiGDgVb1L9cD7MVTp2SP/exec';
        let scriptURL = 'https://script.google.com/macros/s/AKfycbwJkYQSoB4oWnbq_3Pm6LZAMHRT42mLXtqaftQvidWQN3gYfiGDgVb1L9cD7MVTp2SP/exec';
        let proxyURL = 'https://api.allorigins.win/raw?url=';

            
        // This function retrieves the userId from localStorage or fetches it from the API if not available
        async function getUserId() {
            let storedUserId = localStorage.getItem("userId");
        
            if (storedUserId) {
                return storedUserId;
            }
        
            try {
                const response = await fetch(proxyURL + encodeURIComponent(scriptURL), {
                    method: 'GET',
                    // mode: 'no-cors' // 🚀 Fix CORS issues
                });
        
                const text = await response.text();
                console.log("Raw API Response:", text); // ✅ Check if response is readable
                var data = JSON.parse(text);
                return data.userId;
                
            } catch (error) {
                console.error("Error fetching user ID:", error);
                return null;
            }
        }

        
        // Run this function as soon as the page loads
        window.onload = async function() {
            globalUserId = await getUserId();
            console.log("User ID: ", globalUserId); // This can be accessed from anywhere now
        };
            
            
        async function submitFormData() {
            console.log("submitFormData");
        
            const data = {
                userId : globalUserId, // Ensure user ID is sent

                service : document.getElementById("service").value,
        
                taxIndividual : document.getElementById("taxIndividual").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualW2 : document.getElementById("taxIndividualW2").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualBI : document.getElementById("taxIndividualBI").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualStocks : document.getElementById("taxIndividualStocks").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualGain : document.getElementById("taxIndividualGain").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualDependents : document.getElementById("taxIndividualDependents").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualRentals : document.getElementById("taxIndividualRentals").classList.contains("selected") ? "selected" : "not selected",
                taxIndividualStates : getStates("selected-states-individual"),
                taxIndividualPrice : document.getElementById('total-priceIndividual').innerText,
        
        
                taxSCorp : document.getElementById("taxSCorp").classList.contains("selected") ? "selected" : "not selected",
                taxSCorpIncome : document.getElementById("SCorpIncome").classList.contains("selected") ? "selected" : "not selected",
                taxSCorpGain : document.getElementById("SCorpGain").classList.contains("selected") ? "selected" : "not selected",
                taxSCorpCredits : document.getElementById("SCorpCredits").classList.contains("selected") ? "selected" : "not selected",
                taxSCorpProperty : document.getElementById("SCorpProperty").classList.contains("selected") ? "selected" : "not selected",
                taxSCorpStates : getStates("selected-states-scorp"),
                taxSCorpPrice : document.getElementById("total-pricescorp").innerText,
        
        
                taxCCorp : document.getElementById("taxCCorp").classList.contains("selected") ? "selected" : "not selected",
                taxCCorpIncome : document.getElementById("CCorpIncome").classList.contains("selected") ? "selected" : "not selected",
                taxCCorpGain : document.getElementById("CCorpGain").classList.contains("selected") ? "selected" : "not selected",
                taxCCorpCredits : document.getElementById("CCorpCredits").classList.contains("selected") ? "selected" : "not selected",
                taxCCorpProperty : document.getElementById("CCorpProperty").classList.contains("selected") ? "selected" : "not selected",
                taxCCorpStates : getStates("selected-states-ccorp"),
                taxCCorpPrice : document.getElementById("total-priceccorp").innerText,
        
                taxPartnership : document.getElementById("taxPartnership").classList.contains("selected") ? "selected" : "not selected",
                taxPartnershipType : document.getElementById("bussinessType").value,
                taxPartnershipRevenu : document.getElementById("reveneu").value,
                taxPartnershipIncome : document.getElementById("partnershipIncome").classList.contains("selected") ? "selected" : "not selected",
                taxPartnershipGain : document.getElementById("partnershipGain").classList.contains("selected") ? "selected" : "not selected",
                taxPartnershipCredits : document.getElementById("partnershipCredits").classList.contains("selected") ? "selected" : "not selected",
                taxPartnershipProperty : document.getElementById("partnershipProperty").classList.contains("selected") ? "selected" : "not selected",
                taxPartnershipPrice : document.getElementById("total-pricePartnership").innerText,
            
                taxLCC : document.getElementById("taxLCC").classList.contains("selected") ? "selected" : "not selected",
                taxLCCIncome : document.getElementById("lccIncome").classList.contains("selected") ? "selected" : "not selected",
                taxLCCGain : document.getElementById("lccGain").classList.contains("selected") ? "selected" : "not selected",
                taxLCCCredits : document.getElementById("lccCredits").classList.contains("selected") ? "selected" : "not selected",
                taxLCCProperty : document.getElementById("lccProperty").classList.contains("selected") ? "selected" : "not selected",
                taxLCCStates : getStates("selected-states-lcc"),
                taxLCCPrice : document.getElementById("total-pricelcc").innerText,
        
                taxTrust : document.getElementById("taxTrust").classList.contains("selected") ? "selected" : "not selected",
                taxTrustIncome : document.getElementById("trustIncome").classList.contains("selected") ? "selected" : "not selected",
                taxTrustGain : document.getElementById("trustGain").classList.contains("selected") ? "selected" : "not selected",
                taxTrustCredits : document.getElementById("trustCredits").classList.contains("selected") ? "selected" : "not selected",
                taxTrustProperty : document.getElementById("trustProperty").classList.contains("selected") ? "selected" : "not selected",
                taxTrustStates : getStates("selected-states-trust"),
                taxTrustPrice : document.getElementById("total-pricetrust").innerText
            
            };
            // console.log(JSON.stringify(data));
            try {
                const response = await fetch(scriptURL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                console.log('response: ', response);
        
                // ✅ Convert raw HTML response into JSON
                const text = await response.text();
                const jsonText = text.match(/({.*})/); // Extract JSON from response
                const result = jsonText ? JSON.parse(jsonText[0]) : { result: "error" };
        
                if (result.result === 'success') {
                    alert('Data submitted successfully!');
                } else {
                    alert('Failed to submit data.');
                }
            } catch (error) {
                console.error("Error submitting data:", error);
                alert('Failed to submit data.');
            }
        }
        

    </script>

    <style>
        .hidden {
            display: none;
        }

        .checklist-item {
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: top;
            gap: 10px;
            padding: 10px;
        }

        .checklist-item img {
            width: 24px;
            height: 24px;
        }

        .option-button {
            margin: 1px;
            padding: 6px 10px;
            background-color: rgb(255, 255, 255);
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: rgb(0, 0, 0);
        }

        .option-button.selected {
            box-shadow: 0 0 0 3px rgba(211, 194, 247, 0.7);
            border-color: #c5a8ff;
        }

        .option-button:hover {
            background: #f0f0f0;
        }

        .option-button:focus {
            background: #fff;
            color: #000;
        }

        button {
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #f0f0f0;
            /* font- */
        }

        /* Hide the default checkbox */
        .custom-checkbox input[type="checkbox"] {
            display: none;
        }

        /* Create custom design for the checkbox */
        .custom-checkbox .checkbox-design {
            width: 20px;
            height: 20px;
            border: 2px solid #D0D5DD;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
            margin-bottom: -4px;
            position: relative;
            transition: all 0.3s ease;
        }

        /* Style when the checkbox is checked */
        .custom-checkbox input[type="checkbox"]:checked+.checkbox-design {
            background-color: #6c63ff;
            border-color: #c5a8ff;
        }

        /* Add checkmark when checked */
        .custom-checkbox input[type="checkbox"]:checked+.checkbox-design::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }

        /* Optional: Add hover effect */
        .custom-checkbox .checkbox-design:hover {
            border-color: #c5a8ff;
        }

        .result {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .result .billed {
            color: #6c63ff;
            border: 4px solid #c5a8ff;
            /* border: 5px #red; */
            border-radius: 50px;
            padding: 6px 16px;
            transform: scale(0.8);
        }

        .result .bold_price {
            font-size: 52px;
            font-weight: 700;
        }

        .result .tax-deductible {
            color: #ccc;
        }

        .step-header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        #step-4 {
            padding: 20px;
        }

        .form-label {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
            display: block;
        }

        .form-select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-control {
            width: 110%;
            height: 46%;
        }

        .paddingTop40px {
            padding-top: 40px;
        }

        .widthManager {
            display: flex;
            justify-content: space-between;
            gap: 24px
        }

        /* .widthManager>div {
            width: 45%;
        } */

        #tax-option:active
        {
            background-color: #6c63ff;
        }

        .taxheader
        {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .crossButton
        {
            margin-top: 10px;
            cursor: pointer;
        }

        .label{
            font-size: 14px;
            line-height: 20px;
            font-weight: 500;
        }

        .fullWidthdropdown
        {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap:10px;
        }
        
        .calculator-container {
            width: 592px;
            max-width: 100%;
            margin: auto;
            padding: 10px;
        }
        
        @media (max-width: 600px) {
            .calculator-container {
                width: 370px;
            }
        }



    </style>
    <?php
    return ob_get_clean();
}
?>
