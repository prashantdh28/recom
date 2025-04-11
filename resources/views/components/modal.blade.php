<a href="javascript:void(0)" data-modal-toggle="#modal_{{ $id }}">
    <button class="btn btn-icon btn-clear btn-light">
        <i class="ki-filled ki-additem"></i>
    </button>
</a>
<div class="modal" data-modal="true" id="modal_{{ $id }}">
    <div class="modal-content max-w-[600px] top-[20%]">
        <div class="modal-header">
            <h3 class="modal-title">
                Generate Transparency Code
            </h3>
            <button class="btn btn-xs btn-icon btn-light" data-modal-dismiss="true">
                <i class="ki-outline ki-cross"></i>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('transparency-code.store', ['transparency_product_id' => $id]) }}" method="POST" x-data="{labelType: null}">
                @csrf

                    <div class="flex">
                        <x-input-label class="!w-[10%] !font-bold" value="Product: " />
                        <span>{{ $value->product_name }}</span>
                    </div>

                    <div class="grid grid-cols-2 p-2 gap-4 border-b-2 border-solid">
                        <div class="flex">
                            <x-input-label class="!w-[15%]" value="GTIN: " />
                            <span>{{ $value->gtin }}</span>
                        </div>

                        <div class="flex">
                            <x-input-label class="!w-[15%]" value="SKU: " />
                            <span>{{ $value->sku }}</span>
                        </div>
                    </div>

                <!-- Label Type -->
                <div class="grid grid-cols-1 gap-4 mt-4">
                    <x-forms.div>
                        <x-slot name="label">
                            <x-input-label value="Label Type" />
                        </x-slot>
                    
                        <x-slot name="input">
                            <select class="select" name="label_type" @change="labelType = $event.target.value">
                                <option value="">--Select Label Type--</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </x-slot>
                    </x-forms.div>
                </div>

                <!-- FNSKU -->
                <template x-if="labelType == '3' || labelType == '4'">
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <x-forms.div>
                            <x-slot name="label">
                                <x-input-label value="FNSKU" />
                            </x-slot>
                        
                            <x-slot name="input">
                                <x-text-input type="text" required name="fnsku" placeholder="Enter FNSKU" />
                            </x-slot>
                        </x-forms.div>
                    </div>
                </template>

                <!-- Number of Code -->
                <div class="grid grid-cols-1 gap-4 mt-4">
                    <x-forms.div>
                        <x-slot name="label">
                            <x-input-label value="Number of Code" />
                        </x-slot>
                    
                        <x-slot name="input">
                            <x-text-input type="number" required min="1" name="number_of_code" placeholder="Enter Number of Code" />
                        </x-slot>
                    </x-forms.div>
                </div>

                <x-forms.button link="javascript:void(0)">
                    <x-slot name="submitBtn">
                        <x-primary-button class="max-w-[25%]">
                            Save
                        </x-primary-button>
                    </x-slot>

                    <x-slot name="cancelBtn">
                        <x-danger-button data-modal-dismiss="true">
                            Cancel
                        </x-danger-button>
                    </x-slot>
                </x-forms.button>

            </form>
        </div>
    </div>
</div>
