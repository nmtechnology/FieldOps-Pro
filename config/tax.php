<?php

return [
    /*
    |--------------------------------------------------------------------------
    | State Sales Tax Rates
    |--------------------------------------------------------------------------
    |
    | Sales tax rates for each US state. Rates are expressed as decimals.
    | For example, 8.25% is stored as 0.0825.
    |
    | Note: These rates represent state-level sales tax only. Local taxes
    | may apply in addition. For digital products, nexus rules may vary.
    |
    | Last updated: November 2025
    |
    */

    'states' => [
        'AL' => 0.0400, // Alabama - 4%
        'AK' => 0.0000, // Alaska - 0% (local taxes may apply)
        'AZ' => 0.0560, // Arizona - 5.6%
        'AR' => 0.0650, // Arkansas - 6.5%
        'CA' => 0.0725, // California - 7.25%
        'CO' => 0.0290, // Colorado - 2.9%
        'CT' => 0.0635, // Connecticut - 6.35%
        'DE' => 0.0000, // Delaware - 0%
        'FL' => 0.0600, // Florida - 6%
        'GA' => 0.0400, // Georgia - 4%
        'HI' => 0.0400, // Hawaii - 4%
        'ID' => 0.0600, // Idaho - 6%
        'IL' => 0.0625, // Illinois - 6.25%
        'IN' => 0.0700, // Indiana - 7%
        'IA' => 0.0600, // Iowa - 6%
        'KS' => 0.0650, // Kansas - 6.5%
        'KY' => 0.0600, // Kentucky - 6%
        'LA' => 0.0445, // Louisiana - 4.45%
        'ME' => 0.0550, // Maine - 5.5%
        'MD' => 0.0600, // Maryland - 6%
        'MA' => 0.0625, // Massachusetts - 6.25%
        'MI' => 0.0600, // Michigan - 6%
        'MN' => 0.0688, // Minnesota - 6.875%
        'MS' => 0.0700, // Mississippi - 7%
        'MO' => 0.0423, // Missouri - 4.225%
        'MT' => 0.0000, // Montana - 0%
        'NE' => 0.0550, // Nebraska - 5.5%
        'NV' => 0.0685, // Nevada - 6.85%
        'NH' => 0.0000, // New Hampshire - 0%
        'NJ' => 0.0663, // New Jersey - 6.625%
        'NM' => 0.0513, // New Mexico - 5.125%
        'NY' => 0.0400, // New York - 4%
        'NC' => 0.0475, // North Carolina - 4.75%
        'ND' => 0.0500, // North Dakota - 5%
        'OH' => 0.0575, // Ohio - 5.75%
        'OK' => 0.0450, // Oklahoma - 4.5%
        'OR' => 0.0000, // Oregon - 0%
        'PA' => 0.0600, // Pennsylvania - 6%
        'RI' => 0.0700, // Rhode Island - 7%
        'SC' => 0.0600, // South Carolina - 6%
        'SD' => 0.0450, // South Dakota - 4.5%
        'TN' => 0.0700, // Tennessee - 7%
        'TX' => 0.0625, // Texas - 6.25%
        'UT' => 0.0610, // Utah - 6.1%
        'VT' => 0.0600, // Vermont - 6%
        'VA' => 0.0530, // Virginia - 5.3%
        'WA' => 0.0650, // Washington - 6.5%
        'WV' => 0.0600, // West Virginia - 6%
        'WI' => 0.0500, // Wisconsin - 5%
        'WY' => 0.0400, // Wyoming - 4%
        'DC' => 0.0600, // District of Columbia - 6%
    ],

    /*
    |--------------------------------------------------------------------------
    | Digital Product Tax Exemptions
    |--------------------------------------------------------------------------
    |
    | Some states exempt digital products from sales tax. This list includes
    | states where digital products (like info products) may be tax-exempt.
    |
    */

    'digital_exempt_states' => [
        // Uncomment states that should be exempt from tax for digital products
        // 'OR', // Oregon doesn't have sales tax
        // 'NH', // New Hampshire doesn't have sales tax
        // 'DE', // Delaware doesn't have sales tax
        // 'MT', // Montana doesn't have sales tax
        // 'AK', // Alaska doesn't have sales tax
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Nexus States
    |--------------------------------------------------------------------------
    |
    | States where your business has a tax nexus (physical presence or
    | economic nexus). Only collect tax in states where you have nexus.
    |
    */

    'nexus_states' => [
        // Add your nexus states here
        // Example: 'CA', 'NY', 'TX'
        // If empty, tax will be collected for all states based on 'states' config
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Tax Behavior
    |--------------------------------------------------------------------------
    |
    | Controls whether to collect tax by default
    |
    */

    'enabled' => env('TAX_ENABLED', true),
    'collect_for_all_states' => env('TAX_COLLECT_ALL_STATES', true),
];
