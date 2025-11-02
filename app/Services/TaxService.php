<?php

namespace App\Services;

class TaxService
{
    /**
     * Calculate tax for an order based on state
     *
     * @param float $amount The pre-tax amount
     * @param string $state Two-letter state code (e.g., 'CA')
     * @return array ['tax_rate' => float, 'tax_amount' => float, 'total' => float]
     */
    public function calculateTax(float $amount, ?string $state): array
    {
        // If tax is disabled globally, return zero tax
        if (!config('tax.enabled', true)) {
            return [
                'tax_rate' => 0,
                'tax_amount' => 0,
                'total' => $amount,
                'subtotal' => $amount,
            ];
        }

        // If no state provided, return zero tax
        if (!$state) {
            return [
                'tax_rate' => 0,
                'tax_amount' => 0,
                'total' => $amount,
                'subtotal' => $amount,
            ];
        }

        // Normalize state code to uppercase
        $state = strtoupper(trim($state));

        // Check if we should collect tax for this state
        if (!$this->shouldCollectTax($state)) {
            return [
                'tax_rate' => 0,
                'tax_amount' => 0,
                'total' => $amount,
                'subtotal' => $amount,
            ];
        }

        // Get tax rate for state
        $taxRate = $this->getTaxRate($state);

        // Calculate tax amount
        $taxAmount = round($amount * $taxRate, 2);

        // Calculate total
        $total = $amount + $taxAmount;

        return [
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'subtotal' => $amount,
        ];
    }

    /**
     * Get tax rate for a specific state
     *
     * @param string $state Two-letter state code
     * @return float Tax rate as decimal
     */
    public function getTaxRate(string $state): float
    {
        $state = strtoupper(trim($state));
        $rates = config('tax.states', []);
        
        return $rates[$state] ?? 0;
    }

    /**
     * Check if we should collect tax for a state
     *
     * @param string $state Two-letter state code
     * @return bool
     */
    public function shouldCollectTax(string $state): bool
    {
        $state = strtoupper(trim($state));

        // Check if digital products are exempt in this state
        $digitalExemptStates = config('tax.digital_exempt_states', []);
        if (in_array($state, $digitalExemptStates)) {
            return false;
        }

        // Check nexus states
        $nexusStates = config('tax.nexus_states', []);
        $collectForAllStates = config('tax.collect_for_all_states', true);

        // If we have specific nexus states defined, only collect in those states
        if (!empty($nexusStates) && !$collectForAllStates) {
            return in_array($state, $nexusStates);
        }

        // Otherwise collect tax based on state rate
        $rate = $this->getTaxRate($state);
        return $rate > 0;
    }

    /**
     * Get all state names with their codes
     *
     * @return array
     */
    public function getStateNames(): array
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
            'DC' => 'District of Columbia',
        ];
    }

    /**
     * Get formatted tax rate as percentage
     *
     * @param string $state
     * @return string
     */
    public function getTaxRateFormatted(string $state): string
    {
        $rate = $this->getTaxRate($state);
        return number_format($rate * 100, 2) . '%';
    }
}
