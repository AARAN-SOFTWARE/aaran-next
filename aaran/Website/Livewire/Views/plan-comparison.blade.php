<div class="text-black">
    <div class="h-[40vh] bg-blue-500 font-bold text-white text-6xl flex items-center justify-center">
        Plan Comparison
    </div>
    <div class="m-15 py-5">
        <table class="w-full border border-gray-300 border-collapse">
            <thead class="border border-gray-300 border-collapse">
                <tr >
                    <th class="text-xl">All Plans</th>
                    <th class="border border-gray-300 border-collapse p-2 text-xl">Starter</th>
                    <th class="border border-gray-300 border-collapse p-2 text-xl" >Small Business</th>
                    <th class="border border-gray-300 border-collapse p-2 text-xl">Enterprise</th>
                    <th class="border border-gray-300 border-collapse p-2 text-xl">Elite</th>
                </tr>
                <tr>
                    <th class="flex justify-center items-center py-5 gap-2 h-full">
                        <span>Monthly</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                class="sr-only peer"
                                id="priceToggle"
                                onclick="handlePrice()"
                            >
                            <div class="w-12 h-7 bg-black rounded-full peer peer-checked:bg-black transition-colors duration-300"></div>
                            <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform duration-300 peer-checked:translate-x-5"></div>
                        </label>
                        <span>Yearly</span></span>
                    </th>
                    <th class="border border-gray-300 border-collapse py-5 text-2xl  font-normal" id="starterPrice">$9</th>
                    <th class="border border-gray-300 border-collapse py-5 text-2xl  font-normal" id="smallPrice">$19</th>
                    <th class="border border-gray-300 border-collapse py-5 text-2xl  font-normal" id="enterprisePrice">$49</th>
                    <th class="border border-gray-300 border-collapse py-5 text-2xl  font-normal" id="elitePrice">$10</th>
                </tr>
            </thead>
            <tbody>
            @foreach($table as $data)
                <tr>
                    <td class="border border-gray-300 border-collapse p-2 text-lg text-center">{{$data['col1']}}</td>
                    <td class="border border-gray-300 border-collapse p-2 text-lg text-center">{{$data['col2']}}</td>
                    <td class="border border-gray-300 border-collapse p-2 text-lg text-center">{{$data['col3']}}</td>
                    <td class="border border-gray-300 border-collapse p-2 text-lg text-center">{{$data['col4']}}</td>
                    <td class="border border-gray-300 border-collapse p-2 text-lg text-center">{{$data['col5']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-Ui::web.home-new.footer />
    <x-Ui::web.home-new.copyright/>
</div>

<script>
    function handlePrice() {
        const isYearly = document.getElementById('priceToggle').checked;
        const prices = {
            monthly: {
                starter: "$9",
                small: "$19",
                enterprise: "$49",
                elite: "$10"
            },
            yearly: {
                starter: "$60",
                small: "$70",
                enterprise: "$90",
                elite: "$130"
            }
        };
        const type = isYearly ? 'yearly' : 'monthly';
        document.getElementById('starterPrice').textContent = prices[type].starter;
        document.getElementById('smallPrice').textContent = prices[type].small;
        document.getElementById('enterprisePrice').textContent = prices[type].enterprise;
        document.getElementById('elitePrice').textContent = prices[type].elite;
    }
</script>
