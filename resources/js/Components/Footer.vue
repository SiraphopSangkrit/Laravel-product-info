<script setup>
import { GoogleMap, Marker } from 'vue3-google-map'
import { Link } from '@inertiajs/vue3';
const center = { lat: 40.689247, lng: -74.044502 }

</script>
<template>
    <div>
        <div class="w-full bg-[#333552]">

            <div class="flex flex-row justify-center px-6 py-6">
                <div class="mx-6">
                    <h1 class="text-2xl text-orange-400 px-6 py-6">
                        การขายและบริการลูกค้าองค์กร
                    </h1>
                    <div class="text-white text-lg">
                        <p>Line : @tpps คลิก <a href="https://lin.ee/FcYh5sj"
                                class="text-blue-500">https://lin.ee/FcYh5sj</a></p>
                        <p>Shopee : <a
                                href="https://shopee.co.th/thaipipatsolution?categoryId=100636&entryPoint=ShopByPDP&itemId=22779390902"
                                class="text-blue-500">shopee.co.th/thaipipatsolution</a></p>
                        <p>Lazada : <a href="https://s.lazada.co.th/s.PE4ui"
                                class="text-blue-500">https://s.lazada.co.th/s.PE4ui</a></p>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl text-orange-400 px-6 py-6">
                        Contact Us
                    </h1>
                    <div class="text-white">
                        <p>
                            บริษัท ไทยพิพัฒน์โซลูชั่น จำกัด

                        </p>
                        <p>
                            289 หมู่ที่ 4 ถ.ศรีจันทร์ ต.ในเมือง อ.เมือง จ.ขอนแก่น 40000
                        </p>
                        <p>

                            เปิดวันจันทร์ - เสาร์ เวลา 08.00 - 17.30 น.
                        </p>
                        <p>

                            043-224888, 099-4748889
                        </p>

                        
                    </div>
                </div>
                <div class="px-6 py-6">
                    <iframe class="border-2 border-gray-300"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15307.772309719996!2d102.8598235!3d16.4277171!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31228b294186a93b%3A0x75a25ff9ae884554!2z4Lia4Lij4Li04Lip4Lix4LiXIOC5hOC4l-C4ouC4nuC4tOC4nuC4seC4kuC4meC5jOC5guC4i-C4peC4ueC4iuC4seC5iOC4mSDguIjguLPguIHguLHguJQ!5e0!3m2!1sen!2sth!4v1715830865905!5m2!1sen!2sth"
                        width="300" height="200">
                    </iframe>
                </div>
            </div>
            <div class="flex justify-center text-white">
                บริษัท ไทยพิพัฒน์โซลูชั่น จำกัด © All Rights Reserved
            </div>

        </div>
    </div>
</template>
