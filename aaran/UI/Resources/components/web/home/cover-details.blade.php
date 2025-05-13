<div class="py-4 mt-4">
    <div class="font-roboto tracking-wider grid gap-5 sm:gap-10 sm:pt-10">

        <!-- Section Title -->
        <div class="flex items-center gap-x-3 justify-center animate__animated wow bounceInDown" data-wow-duration="3s">
            <span class="h-2 px-4 bg-gradient-to-r from-white to-[#070609]"></span>
            <span class="text-[#070609] text-xs sm:text-xl font-semibold">Billing Made Simple and Efficient</span>
            <span class="h-2 px-4 bg-gradient-to-r from-[#070609] to-white"></span>
        </div>

        <div class="text-center text-black text-1xl sm:text-3xl md:text-4xl lg:text-5xl font-semibold">Try India’s easiest GST billing platform</div>

        <!-- Feature Cards Grid -->
        <div class="grid w-10/12 mx-auto gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <x-Ui::web.home.items.cover-card
                title="Sales & Purchase"
                desc="Create sleek invoices with the click of a button. Customize templates to reflect your brand."
                border="border-[#66C25F]"
                bg_color="bg-[#66C25F]"
            >
                <x-Ui::web.home.svg-icons.sales-purchase-cover/>
            </x-Ui::web.home.items.cover-card>

            <x-Ui::web.home.items.cover-card
                title="Book Keeping"
                desc="Software designed to simplify accounting and bookkeeping for all businesses."
                border="border-[#FEBA35]"
                bg_color="bg-[#FEBA35]"
            >
                <x-Ui::web.home.svg-icons.pay-rec-cover/>
            </x-Ui::web.home.items.cover-card>

            <x-Ui::web.home.items.cover-card
                title="Reporting Tools"
                desc="Use your report data to make inferences and create robust, up-to-date business plans."
                border="border-[#464B8B]"
                bg_color="bg-[#464B8B]"
            >
                <x-Ui::web.home.svg-icons.report-cover/>
            </x-Ui::web.home.items.cover-card>

            <x-Ui::web.home.items.cover-card
                title="e-Invoice"
                desc="Automatic E-Invoice Generation, keep track of their financial operations."
                border="border-[#8E9BA3]"
                bg_color="bg-[#8E9BA3]"
            >
                <x-Ui::web.home.svg-icons.e-inv-cover/>
            </x-Ui::web.home.items.cover-card>
        </div>
    </div>
</div>
