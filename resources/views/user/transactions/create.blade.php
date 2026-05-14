<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600 dark:text-blue-400">Transaksi Baru</p>
            <div>
                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 dark:text-slate-100 mt-1">Tambah Transaksi</h2>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Buat catatan pemasukan atau pengeluaran baru ke dalam jurnal keuangan Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8" x-data="{ 
        type: '{{ old('type', 'income') }}',
        totalAmount: '{{ old('amount') }}',
        payments: {{ json_encode(old('payments', [['payment_method_id' => '', 'amount' => '']])) }},
        categories: {{ $categories->map(fn($c) => [
            'id' => $c->id,
            'name' => $c->name,
            'methods' => $c->paymentMethods->map(fn($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'user_balance' => $m->user_balance
            ])
        ])->toJson() }},
        
        addPayment() {
            this.payments.push({ payment_method_id: '', amount: '' });
        },
        
        removePayment(index) {
            if (this.payments.length > 1) {
                this.payments.splice(index, 1);
            }
        },

        formatDisplay(val) {
            if (!val) return '';
            let num = val.toString().replace(/\D/g, '');
            return new Intl.NumberFormat('id-ID').format(num);
        },

        parseNumber(val) {
            if (!val) return 0;
            return parseInt(val.toString().replace(/\D/g, '')) || 0;
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        },

        get remainingAmount() {
            const total = this.parseNumber(this.totalAmount);
            const paid = this.payments.reduce((acc, curr) => acc + this.parseNumber(curr.amount), 0);
            return total - paid;
        },

        autoAllocate() {
            if (this.payments.length === 1) {
                this.payments[0].amount = this.totalAmount;
            }
        }
    }">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="app-panel mb-6 border border-red-200 bg-red-50 px-5 py-4 text-red-700 dark:border-red-900/30 dark:bg-red-900/10 dark:text-red-400">
                    <ul class="list-disc pl-5 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-2xl p-6 sm:p-10 transition-colors">
                <form method="POST" action="{{ route('transactions.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="type" value="Jenis Transaksi" />
                            <select id="type" name="type" x-model="type" class="app-field mt-1.5 font-semibold" required>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="transaction_date" value="Tanggal Transaksi" />
                            <x-text-input id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="mt-1.5 w-full" required />
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" value="Keterangan / Deskripsi" />
                        <x-text-input id="description" type="text" name="description" value="{{ old('description') }}" class="mt-1.5 w-full" placeholder="Contoh: Gaji bulanan / Makan siang" required autocapitalize="sentences" spellcheck="true" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <div class="flex flex-col gap-6 mb-8">
                            <div>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Detail Nominal & Pembayaran</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola sumber dana transaksi Anda</p>
                            </div>
                            
                            <div class="bg-blue-600 dark:bg-blue-600 p-6 rounded-2xl border border-blue-700 dark:border-blue-500 shadow-lg shadow-blue-500/20 transform-gpu transition-all">
                                <div class="flex flex-col gap-3">
                                    <p class="text-[10px] font-black text-blue-100 uppercase tracking-[0.3em]">Total Transaksi</p>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-blue-200 font-black text-xl">Rp</span>
                                        </div>
                                        <input type="hidden" name="amount" :value="parseNumber(totalAmount)">
                                        <input type="text" 
                                               inputmode="numeric"
                                               x-model="totalAmount" 
                                               @input="totalAmount = formatDisplay($event.target.value); autoAllocate()" 
                                               class="w-full bg-blue-700/30 border-none rounded-xl py-4 pl-14 pr-4 text-3xl font-black text-white placeholder:text-blue-300/50 focus:ring-2 focus:ring-white/20 transition-all text-right" 
                                               placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(payment, index) in payments" :key="index">
                                <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest" x-text="'Sumber Dana #' + (index + 1)"></span>
                                        <button type="button" @click="removePayment(index)" x-show="payments.length > 1" class="text-rose-500 hover:text-rose-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4" x-data="{ 
                                        selectedCategoryId: '',
                                        selectedCategoryName: '',
                                        selectedMethodName: '',
                                        selectedBalance: 0,
                                        showCategoryList: false,
                                        showMethodList: false,
                                        searchCategory: '',
                                        searchMethod: '',
                                        
                                        init() {
                                            if (payment.payment_method_id) {
                                                const cat = categories.find(c => c.methods.some(m => m.id == payment.payment_method_id));
                                                if (cat) {
                                                    this.selectedCategoryId = cat.id;
                                                    this.selectedCategoryName = cat.name;
                                                    const meth = cat.methods.find(m => m.id == payment.payment_method_id);
                                                    if (meth) {
                                                        this.selectedMethodName = meth.name;
                                                        this.selectedBalance = meth.user_balance;
                                                    }
                                                }
                                            }
                                        },

                                        get filteredCategories() {
                                            if (!this.searchCategory) return categories;
                                            return categories.filter(c => c.name.toLowerCase().includes(this.searchCategory.toLowerCase()));
                                        },

                                        get filteredMethods() {
                                            if (!this.selectedCategoryId) return [];
                                            const cat = categories.find(c => c.id == this.selectedCategoryId);
                                            if (!cat) return [];
                                            if (!this.searchMethod) return cat.methods;
                                            return cat.methods.filter(m => m.name.toLowerCase().includes(this.searchMethod.toLowerCase()));
                                        },

                                        selectCategory(cat) {
                                            this.selectedCategoryId = cat.id;
                                            this.selectedCategoryName = cat.name;
                                            this.showCategoryList = false;
                                            this.searchCategory = '';
                                            // Reset method if category changes
                                            payment.payment_method_id = '';
                                            this.selectedMethodName = '';
                                            this.selectedBalance = 0;
                                        },

                                        selectMethod(meth) {
                                            payment.payment_method_id = meth.id;
                                            this.selectedMethodName = meth.name;
                                            this.selectedBalance = meth.user_balance;
                                            this.showMethodList = false;
                                            this.searchMethod = '';
                                        }
                                    }">
                                        <!-- Kategori Dropdown -->
                                        <div class="md:col-span-2 relative">
                                            <div @click="showCategoryList = !showCategoryList" 
                                                 class="app-field flex items-center justify-between cursor-pointer group h-full"
                                                 :class="showCategoryList ? 'ring-2 ring-blue-500/20 border-blue-500' : ''">
                                                <span x-text="selectedCategoryName || '-- Pilih Kategori --'" 
                                                      :class="!selectedCategoryName ? 'text-slate-400' : 'text-slate-900 dark:text-slate-100 font-bold'"></span>
                                                <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                            <!-- Dropdown List -->
                                            <div x-show="showCategoryList" @click.away="showCategoryList = false" x-transition class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden">
                                                <div class="p-2 border-b border-slate-100 dark:border-slate-700">
                                                    <input type="text" x-model="searchCategory" class="w-full px-3 py-2 text-sm bg-slate-50 dark:bg-slate-900 border-none rounded-lg focus:ring-0" placeholder="Cari kategori...">
                                                </div>
                                                <div class="max-h-48 overflow-y-auto">
                                                    <template x-for="cat in filteredCategories" :key="cat.id">
                                                        <div @click="selectCategory(cat)" class="px-4 py-2.5 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer flex items-center justify-between transition-colors" :class="selectedCategoryId == cat.id ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                                            <span x-text="cat.name"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Metode Dropdown -->
                                        <div class="md:col-span-2 relative">
                                            <input type="hidden" :name="'payments['+index+'][payment_method_id]'" :value="payment.payment_method_id">
                                            <div @click="if(selectedCategoryId) showMethodList = !showMethodList" 
                                                 class="app-field flex items-center justify-between group h-full"
                                                 :class="{
                                                    'ring-2 ring-blue-500/20 border-blue-500': showMethodList,
                                                    'opacity-50 cursor-not-allowed bg-slate-100 dark:bg-slate-800/50': !selectedCategoryId,
                                                    'cursor-pointer': selectedCategoryId
                                                 }">
                                                <div class="flex flex-col">
                                                    <span x-text="selectedMethodName || '-- Pilih Metode --'" 
                                                          :class="!selectedMethodName ? 'text-slate-400' : 'text-slate-900 dark:text-slate-100 font-bold'"></span>
                                                    <template x-if="selectedMethodName && type === 'expense'">
                                                        <span class="text-[10px] font-bold uppercase tracking-wider" 
                                                              :class="selectedBalance < payment.amount ? 'text-rose-500' : 'text-emerald-500'">
                                                            Saldo: Rp <span x-text="formatNumber(selectedBalance)"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                                <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                            <!-- Dropdown List -->
                                            <div x-show="showMethodList" @click.away="showMethodList = false" x-transition class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden">
                                                <div class="p-2 border-b border-slate-100 dark:border-slate-700">
                                                    <input type="text" x-model="searchMethod" class="w-full px-3 py-2 text-sm bg-slate-50 dark:bg-slate-900 border-none rounded-lg focus:ring-0" placeholder="Cari metode...">
                                                </div>
                                                <div class="max-h-48 overflow-y-auto">
                                                    <template x-for="meth in filteredMethods" :key="meth.id">
                                                        <div @click="selectMethod(meth)" class="px-4 py-2.5 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer flex items-center justify-between transition-colors" :class="payment.payment_method_id == meth.id ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300'">
                                                            <div class="flex flex-col">
                                                                <span x-text="meth.name"></span>
                                                                <span class="text-[10px] opacity-60" x-text="'Saldo: Rp ' + formatNumber(meth.user_balance)"></span>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nominal -->
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-slate-400 text-xs font-bold">Rp</span>
                                            </div>
                                            <input type="hidden" :name="'payments['+index+'][amount]'" :value="parseNumber(payment.amount)">
                                            <input type="text" 
                                                   inputmode="numeric"
                                                   x-model="payment.amount" 
                                                   @input="payment.amount = formatDisplay($event.target.value)"
                                                   class="app-field pl-8 font-bold text-right" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <button type="button" @click="addPayment()" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Tambah Pembayaran (Combo)
                            </button>
                            
                            <div class="flex items-center gap-4 text-sm font-bold">
                                <span class="text-slate-400">Selisih:</span>
                                <span :class="remainingAmount === 0 ? 'text-emerald-500' : 'text-rose-500'" 
                                      x-text="'Rp ' + formatNumber(remainingAmount)"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end border-t border-slate-100 dark:border-slate-800 pt-6 mt-6">
                        <a href="{{ route('transactions.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            Batal
                        </a>
                        <button type="submit" 
                                :disabled="remainingAmount !== 0"
                                :class="remainingAmount !== 0 ? 'opacity-50 cursor-not-allowed' : ''"
                                class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
