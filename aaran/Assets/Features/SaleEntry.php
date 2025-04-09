<?php

namespace Aaran\Assets\Features;

class SaleEntry
{
    public static function enabled(string $feature): bool
    {
        return match (config('aaran-app.app_code')) {
            config('software.DEVELOPER') => in_array($feature, config('developer.SalesEntry', [])),
            config('software.OFFSET') => in_array($feature, config('offset.SalesEntry', [])),
        };
    }

    public static function hasOrder(): bool
    {
        return static::enabled(static::order());
    }

    public static function order(): string
    {
        return 'order';
    }

    /**
     * billingAddress
     * @return bool
     */
    public static function hasBillingAddress(): bool
    {
        return static::enabled(static::billingAddress());
    }

    public static function billingAddress(): string
    {
        return 'billingAddress';
    }

    /**
     * deliveryAddress
     * @return bool
     */
    public static function hasShippingAddress(): bool
    {
        return static::enabled(static::shippingAddress());
    }

    public static function shippingAddress(): string
    {
        return 'shippingAddress';
    }

    /**
     * Style
     * @return bool
     */
    public static function hasStyle(): bool
    {
        return static::enabled(static::style());
    }

    public static function style(): string
    {
        return 'style';
    }

    /**
     * jon_no
     * @return bool
     */
    public static function hasJob_no(): bool
    {
        return static::enabled(static::job_no());
    }

    public static function job_no(): string
    {
        return 'job_no';
    }

    /**
     * despatch
     * @return bool
     */
    public static function hasDespatch(): bool
    {
        return static::enabled(static::despatch());
    }

    public static function despatch(): string
    {
        return 'despatch';
    }


    /**
     * colour
     * @return bool
     */
    public static function hasColour(): bool
    {
        return static::enabled(static::colour());
    }

    public static function colour(): string
    {
        return 'colour';
    }


    /**
     * size
     * @return bool
     */
    public static function hasSize(): bool
    {
        return static::enabled(static::size());
    }

    public static function size(): string
    {
        return 'size';
    }

    /**
     * Description
     * @return bool
     */
    public static function hasProductDescription(): bool
    {
        return static::enabled(static::productDescription());
    }

    public static function productDescription(): string
    {
        return 'productDescription';
    }

    /**
     * Transport
     * @return bool
     */
    public static function hasTransport(): bool
    {
        return static::enabled(static::transport());
    }

    public static function transport(): string
    {
        return 'transport';
    }

    /**
     * Destination
     * @return bool
     */
    public static function hasDestination(): bool
    {
        return static::enabled(static::destination());
    }

    public static function destination(): string
    {
        return 'destination';
    }

    /**
     * Bundle
     * @return bool
     */
    public static function hasBundle(): bool
    {
        return static::enabled(static::bundle());
    }

    public static function bundle(): string
    {
        return 'bundle';
    }

    /**
     * Po
     * @return bool
     */
    public static function hasPo_no(): bool
    {
        return static::enabled(static::po_no());
    }

    public static function po_no(): string
    {
        return 'po_no';
    }

    /**
     * Dc
     * @return bool
     */
    public static function hasDc_no(): bool
    {
        return static::enabled(static::dc_no());
    }

    public static function dc_no(): string
    {
        return 'dc_no';
    }


    public static function hasNo_of_roll(): bool
    {
        return static::enabled(static::no_of_roll());
    }

    public static function no_of_roll(): string
    {
        return 'no_of_roll';
    }

    /**
     * Eway
     * @return bool
     */
    public static function hasEway(): bool
    {
        return static::enabled(static::eway());
    }

    public static function eway(): string
    {
        return 'eway';
    }

    /**
     * Einvoice
     * @return bool
     */
    public static function hasEinvoice(): bool
    {
        return static::enabled(static::einvoice());
    }

    public static function einvoice(): string
    {
        return 'einvoice';
    }

}


