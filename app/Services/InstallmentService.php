<?php

namespace App\Services;

class InstallmentService
{
    const PLANS = [
        'monthly' => [
            'months' => 1,
            'count' => 1,
            'interest_rate' => 0,
            'label' => 'Bulanan (1 Bulan)',
        ],
        'quarterly' => [
            'months' => 3,
            'count' => 3,
            'interest_rate' => 0.02,
            'label' => 'Per 3 Bulan',
        ],
        'semi_annually' => [
            'months' => 6,
            'count' => 6,
            'interest_rate' => 0.035,
            'label' => 'Per 6 Bulan',
        ],
    ];

    public static function calculate(float $totalAmount, string $installmentPlan): array
    {
        $plan = self::PLANS[$installmentPlan] ?? self::PLANS['monthly'];

        $installmentCount = $plan['count'];
        $interestRate = $plan['interest_rate'];
        $totalWithFee = $totalAmount * (1 + $interestRate);
        $serviceFee = $totalWithFee - $totalAmount;
        $perInstallment = round($totalWithFee / $installmentCount, 2);

        $remainder = round($totalWithFee - ($perInstallment * $installmentCount), 2);
        $perInstallment = round($perInstallment + $remainder, 2);

        return [
            'installment_plan' => $installmentPlan,
            'installment_count' => $installmentCount,
            'installment_period_months' => $plan['months'],
            'total_original' => $totalAmount,
            'total_with_fee' => round($totalWithFee, 2),
            'service_fee' => round($serviceFee, 2),
            'per_installment' => $perInstallment,
            'interest_rate' => $interestRate,
            'label' => $plan['label'],
        ];
    }

    public static function getDueDates(string $installmentPlan, int $count): array
    {
        $dates = [];
        $interval = match ($installmentPlan) {
            'monthly' => 1,
            'quarterly' => 3,
            'semi_annually' => 6,
            default => 1,
        };

        for ($i = 1; $i <= $count; $i++) {
            $months = ($i - 1) * $interval;
            $dates[] = now()->addMonths($months)->startOfMonth()->toDateString();
        }

        return $dates;
    }

    public static function plans(): array
    {
        return self::PLANS;
    }
}
