<x-admin-layout>
    <x-slot name="header">
        POS Kasir Warung Bakso Pak Timan
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8"
             x-data="pos({ menus: {{ $menus->map(fn($m) => [
                    'id' => $m->id,
                    'name' => $m->nama_menu,
                    'price' => $m->harga,
                    'category' => $m->kategori
             ])->toJson() }} })">

            {{-- Alert sukses --}}
            @if (session('status'))
                <div class="mb-3 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Alert pembayaran kurang --}}
            @if (!empty($paymentError))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="mb-3 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700 flex items-center justify-between">
                    <span>{{ $paymentError }}</span>
                    <button type="button" @click="show = false" class="ml-2 text-[10px] underline">
                        Tutup
                    </button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kiri: Search + Category + Grid Menu --}}
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            🔍 Cari Menu Cepat
                        </h3>

                        {{-- Filter kategori --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
                            <button type="button" @click="setCategory('all')"
                                    :class="`p-2.5 rounded-lg text-xs font-semibold transition-all ${category === 'all' ? 'bg-emerald-100 text-emerald-800 border-2 border-emerald-400 shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`">
                                Semua
                            </button>
                            <button type="button" @click="setCategory('bakso')"
                                    :class="`p-2.5 rounded-lg text-xs font-semibold transition-all ${category === 'bakso' ? 'bg-orange-100 text-orange-800 border-2 border-orange-400 shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`">
                                Bakso
                            </button>
                            <button type="button" @click="setCategory('mie')"
                                    :class="`p-2.5 rounded-lg text-xs font-semibold transition-all ${category === 'mie' ? 'bg-blue-100 text-blue-800 border-2 border-blue-400 shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`">
                                Mie
                            </button>
                            <button type="button" @click="setCategory('minuman')"
                                    :class="`p-2.5 rounded-lg text-xs font-semibold transition-all ${category === 'minuman' ? 'bg-indigo-100 text-indigo-800 border-2 border-indigo-400 shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}`">
                                Minuman
                            </button>
                        </div>

                        {{-- Search --}}
                        <div class="relative mb-4">
                            <input type="text"
                                   x-model="search"
                                   @input.debounce.200ms="filterMenus()"
                                   placeholder="Cari Bakso Urat, Mie Ayam..."
                                   class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        {{-- Grid menu besar + pintasan qty --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-[450px] overflow-y-auto">
                            <template x-for="menu in filteredMenus" :key="menu.id">
                                <div
                                    class="w-full bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-300 rounded-xl p-3 transition-all shadow-sm hover:shadow-md flex flex-col justify-between">
                                    {{-- bagian atas: nama + harga (klik = qty 1) --}}
                                    <button type="button" @click="quickAdd(menu, 1)"
                                            class="w-full text-left flex items-start gap-2 mb-2">
                                        <span class="w-2 h-2 rounded-full mt-1 flex-shrink-0"
                                              :class="{
                                                  'bg-orange-400': menu.category === 'bakso',
                                                  'bg-blue-400': menu.category === 'mie',
                                                  'bg-indigo-400': menu.category === 'minuman'
                                              }"></span>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2"
                                                 x-text="menu.name"></div>
                                            <div class="text-emerald-600 text-xs mt-1"
                                                 x-text="`Rp${formatNumber(menu.price)}`"></div>
                                        </div>
                                    </button>

                                    {{-- pintasan qty kecil --}}
                                    <div class="mt-1 flex items-center justify-between">
                                        <div class="flex gap-1">
                                            <template x-for="q in [1,2,3]" :key="q">
                                                <button type="button"
                                                        @click="quickAdd(menu, q)"
                                                        class="px-2 py-1 text-[11px] rounded-md border border-emerald-200 text-emerald-700 bg-white hover:bg-emerald-50 font-semibold">
                                                    x<span x-text="q"></span>
                                                </button>
                                            </template>
                                        </div>
                                        <span class="text-[11px] text-gray-500">
                                            Tap nama = x1
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Keranjang + Pembayaran --}}
                <div class="space-y-4">
                    {{-- Keranjang --}}
                    <div class="bg-white shadow-sm rounded-xl p-4 h-80 flex flex-col border border-gray-100">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b">
                            <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                                🛒 Keranjang
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full"
                                      x-text="items.length"></span>
                            </h3>
                            <button type="button" @click="clearCart()"
                                    class="px-3 py-1 bg-red-50 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-100 transition-all">
                                Hapus All
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto space-y-2 mb-4">
                            <template x-if="items.length === 0">
                                <div class="text-center py-8 text-gray-500">
                                    <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-2xl flex items-center justify-center text-2xl">
                                        🛒
                                    </div>
                                    <p class="text-sm">Keranjang kosong</p>
                                </div>
                            </template>

                            <template x-for="(item, index) in items" :key="index">
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-3 rounded-xl border border-gray-200 hover:shadow-sm transition-all text-xs">
                                    {{-- Baris 1: nama + total --}}
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="w-2 h-2 rounded-full flex-shrink-0"
                                                  :class="{
                                                    'bg-orange-400': getCategoryColor(item.menu_id) === 'orange',
                                                    'bg-blue-400': getCategoryColor(item.menu_id) === 'blue',
                                                    'bg-indigo-400': getCategoryColor(item.menu_id) === 'indigo'
                                                  }"></span>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-gray-900 text-[13px] leading-snug truncate"
                                                     x-text="item.name"></div>
                                                <div class="text-gray-500 text-[10px]"
                                                     x-text="`Rp${formatNumber(item.price)}`"></div>
                                            </div>
                                        </div>
                                        <div class="text-right flex-shrink-0 min-w-[4.5rem]">
                                            <div class="font-bold text-sm text-emerald-600"
                                                 x-text="`Rp${formatNumber(item.qty * item.price)}`"></div>
                                        </div>
                                    </div>

                                    {{-- Baris 2: qty kecil + hapus --}}
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-1">
                                            <button type="button" @click="decreaseQty(index)"
                                                    class="w-5 h-5 flex items-center justify-center bg-white border border-gray-300 hover:border-red-400 hover:bg-red-50 text-red-500 rounded-md text-[11px] font-bold transition-all">
                                                −
                                            </button>
                                            <span class="min-w-[1.5rem] px-1 h-5 flex items-center justify-center text-[11px] font-bold text-gray-900 bg-white border border-gray-300 rounded-md"
                                                  x-text="item.qty"></span>
                                            <button type="button" @click="increaseQty(index)"
                                                    class="w-5 h-5 flex items-center justify-center bg-white border border-gray-300 hover:border-emerald-400 hover:bg-emerald-50 text-emerald-600 rounded-md text-[11px] font-bold transition-all">
                                                +
                                            </button>
                                        </div>
                                        <button type="button" @click="removeItem(index)"
                                                class="text-[11px] text-red-500 hover:underline">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="pt-3 border-t border-gray-200 space-y-2 p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">Rp <span x-text="formatNumber(subtotal)"></span></span>
                            </div>
                            <div class="flex justify-between text-sm font-bold text-emerald-700">
                                <span>TOTAL</span>
                                <span>Rp <span x-text="formatNumber(grandTotal)"></span></span>
                            </div>
                        </div>
                    </div>

                    {{-- Pembayaran --}}
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 shadow-sm rounded-xl p-4 border border-emerald-200">
                        <h3 class="text-sm font-semibold text-emerald-800 mb-4 flex items-center gap-2">
                            💰 Pembayaran
                        </h3>

                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Metode Bayar</label>
                                <select x-model="paymentMethod"
                                        class="block w-full border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="cash">💵 Tunai</option>
                                    <option value="qris">📱 QRIS</option>
                                    <option value="transfer">🏦 Transfer</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Dibayar (Rp)</label>
                                <input type="number" min="0" x-model.number="paid"
                                       placeholder="Masukkan nominal"
                                       class="block w-full border-2 border-emerald-200 rounded-lg text-lg font-bold text-right p-3 bg-white focus:border-emerald-500 focus:ring-2 ring-emerald-200">
                            </div>

                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                <span class="text-sm font-medium text-gray-700">Kembalian</span>
                                <span class="text-xl font-bold text-emerald-600">
                                    Rp <span x-text="formatNumber(changeAmount)"></span>
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-2">
                                <button type="button" @click="quickPay()"
                                        class="p-2.5 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 shadow-sm transition-all text-xs">
                                    Bayar Tepat
                                </button>
                                <template x-for="amount in [10000,20000,50000]" :key="amount">
                                    <button type="button" @click="setPaid(amount)"
                                            class="p-2.5 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 shadow-sm transition-all text-xs flex items-center justify-center">
                                        <span x-text="`Rp${formatNumber(amount)}`"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- Form submit ke backend --}}
                        <form action="{{ route('admin.pos.store') }}" method="POST">
                            @csrf

                            <template x-for="(item, index) in items" :key="index">
                                <div style="display:none;">
                                    <input type="hidden" :name="`items[${index}][menu_id]`" :value="item.menu_id">
                                    <input type="hidden" :name="`items[${index}][qty]`" :value="item.qty">
                                    <input type="hidden" :name="`items[${index}][price]`" :value="item.price">
                                </div>
                            </template>

                            <input type="hidden" name="subtotal" :value="subtotal">
                            <input type="hidden" name="discount" :value="discount">
                            <input type="hidden" name="grand_total" :value="grandTotal">
                            <input type="hidden" name="paid_amount" :value="paid">
                            <input type="hidden" name="payment_method" :value="paymentMethod">

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold py-3.5 px-6 rounded-xl shadow-xl hover:shadow-2xl text-sm transition-all duration-200 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                                    :disabled="items.length === 0 || grandTotal <= 0 || paid < grandTotal">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>PROSES TRANSAKSI</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pos({ menus }) {
            return {
                menus,
                filteredMenus: [],
                search: '',
                category: 'all',
                form: { menu_id: '', qty: 1, price: 0 },
                items: [],
                discount: 0,
                paid: 0,
                paymentMethod: 'cash',

                init() {
                    this.filteredMenus = this.menus;
                },

                formatNumber(value) {
                    return (value || 0).toLocaleString('id-ID');
                },

                setCategory(cat) {
                    this.category = cat;
                    this.filterMenus();
                },

                filterMenus() {
                    let filtered = this.menus;

                    if (this.category !== 'all') {
                        filtered = filtered.filter(menu => menu.category === this.category);
                    }

                    if (this.search.trim()) {
                        filtered = filtered.filter(menu =>
                            menu.name.toLowerCase().includes(this.search.toLowerCase().trim())
                        );
                    }

                    this.filteredMenus = filtered;
                },

                getCategoryColor(menuId) {
                    const menu = this.menus.find(m => m.id == menuId);
                    if (!menu) return 'gray';
                    switch (menu.category) {
                        case 'bakso': return 'orange';
                        case 'mie': return 'blue';
                        case 'minuman': return 'indigo';
                        default: return 'gray';
                    }
                },

                selectMenu(menu) {
                    this.quickAdd(menu, 1);
                },

                quickAdd(menu, qty) {
                    this.form.menu_id = menu.id;
                    this.form.price = menu.price;
                    this.form.qty = qty;
                    this.addItem();
                },

                setPaid(amount) {
                    this.paid = amount;
                },

                quickPay() {
                    this.paid = this.grandTotal;
                },

                increaseQty(index) {
                    if (this.items[index].qty < 999) {
                        this.items[index].qty++;
                    }
                },

                decreaseQty(index) {
                    if (this.items[index].qty > 1) {
                        this.items[index].qty--;
                    }
                },

                addItem() {
                    if (!this.form.menu_id || this.form.qty <= 0) return;

                    const menu = this.menus.find(m => m.id == this.form.menu_id);
                    if (!menu) return;

                    const existing = this.items.find(i =>
                        i.menu_id == this.form.menu_id && i.price == this.form.price
                    );
                    if (existing) {
                        existing.qty += this.form.qty;
                    } else {
                        this.items.push({
                            menu_id: this.form.menu_id,
                            name: menu.name,
                            qty: this.form.qty,
                            price: this.form.price,
                        });
                    }

                    this.form.qty = 1;
                    this.search = '';
                    this.filterMenus();
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                },

                clearCart() {
                    this.items = [];
                },

                get subtotal() {
                    return this.items.reduce((sum, item) => sum + (item.qty * item.price), 0);
                },

                get grandTotal() {
                    return Math.max(this.subtotal - this.discount, 0);
                },

                get changeAmount() {
                    return Math.max(this.paid - this.grandTotal, 0);
                }
            }
        }
    </script>
</x-admin-layout>
