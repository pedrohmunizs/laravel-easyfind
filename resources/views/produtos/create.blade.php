@extends('layouts.main')

@section('title', 'Criar produto')

@section('content')
@include('includes.header')
@include('includes.menu', ['estabelecimento' => $estabelecimento])
<form id="form_produto" action="/produtos" method="POST" novalidate enctype="multipart/form-data">
    @csrf
    <div class="col-md-10 offset-md-2 px-4 py-5 d-flex flex-column gap-2">
        <h3 class="m-0">Produtos</h3>
        <div class="d-flex flex-row gap-2">
            <p class="fc-primary">Produtos</p>
            <i class="bi bi-chevron-right fc-gray"></i>
            <a href="/produtos/{{$estabelecimento->id}}" class="a-default">
                <p class="fc-primary">Lista de produtos</p>
            </a>
            <i class="bi bi-chevron-right fc-gray"></i>
            <p class="fc-gray">Cadastrar produto</p>
        </div>
        <div class="col-md-12 d-flex flex-row justify-content-between">
            <div class="d-flex flex-column gap-4" style="width: 72%;">
                <div class="bg-white container-default p-3 gap-3">
                    <h5>Informações Gerais</h5>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="nome">Nome do produto</label>
                        <input type="text" name="produto[nome]" class=" px-3 py-2 input-default w-100" maxlength="15">
                    </div>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="nome">Descrição</label>
                        <textarea name="produto[descricao]" id="" class="px-3 py-2 input-default w-100" maxlength="255"></textarea>
                    </div>
                </div>
                <div class="bg-white container-default p-3 gap-3">
                    <h5>Imagens</h5>
                    <div class="form-group d-flex flex-column align-items-center dashed br-8 py-2 bgc-input">
                        <input type="file" class="form-control-file none" id="images" multiple>
                        <div class="rounded-circle bgc-primary d-flex justify-content-center align-items-center" style="height: 35px; width:35px;border: 4px solid #EFEFFD;">
                            <i class="bi bi-image"></i>
                        </div>
                        <p class="fs-13">Adicione até 5 imagens do produto</p>
                        <button type="button" id="addImageButton" class="btn-default px-3 py-2">Adicionar Imagem</button>
                        <div class="mt-3 d-flex flex-wrap justify-content-center" id="imagePreviewContainer"></div>
                    </div>
                </div>
                <div class="bg-white container-default p-3 gap-3">
                    <h5>Preços</h5>
                    <div class="d-flex flex-row gap-4 d-flex align-items-end">
                        <div class="d-flex flex-column">
                            <label class="label-default" for="nome">Preço base</label>
                            <input type="text" id="preco" name="produto[preco]" class=" px-3 py-2 input-default">
                        </div>
                        <div class="d-flex flex-column">
                            <label class="label-default" for="nome">Preço oferta</label>
                            <input type="text" id="preco_oferta" name="produto[preco_oferta]" class=" px-3 py-2 input-default">
                        </div>
                        <div class="d-flex flex-row gap-2 align-items-baseline">
                            <input class="form-check-input" name="produto[is_promocao_ativa]" type="checkbox" id="defaultCheck1">
                            <label class="label-default" for="defaultCheck1">Ativar/Desativar oferta</label>
                        </div>
                    </div>
                </div>
                <div class="bg-white container-default p-3 gap-3">
                    <h5>Controle de estoque</h5>
                    <div class="d-flex flex-row gap-4">
                        <div class="d-flex flex-column">
                            <label class="label-default" for="nome">SKU</label>
                            <input type="text" name="produto[codigo_sku]" class=" px-3 py-2 input-default w-100">
                        </div>
                        <div class="d-flex flex-column">
                            <label class="label-default" for="nome">Código de barras</label>
                            <input type="text" name="produto[codigo_barras]" class=" px-3 py-2 input-default w-100">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex flex-column gap-4">
                <div class="bg-white container-default p-3 d-flex flex-column gap-2" style="height: fit-content;">
                    <h5>Tags</h5>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="nome">Tags do produto</label>
                        <select id="tags" class="px-3 py-2 input-default w-100">
                            <option value="">Selecione as tags</option>
                            @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->descricao}}</option>
                            @endforeach
                        </select>
                        <button type="button" id="add_tag" class="btn-default btn-large mt-2">Adicionar</button>
                        <div id="tags-select" class="d-flex flex-column gap-1 mt-2 mb-1"></div>
                        <input type="text" class="d-none" id="tags-produto" name="produto_tag[fk_tag]">
                    </div>
                </div>
                <div class="bg-white container-default p-3 d-flex flex-column gap-2" style="height: fit-content;">
                    <h5>Status</h5>
                    <div class="d-flex flex-column">
                        <label class="label-default" for="nome">Status do produto</label>
                        <select name="produto[is_ativo]" class="px-3 py-2 input-default w-100">
                            <option value="1">Ativado</option>
                            <option value="0">Desativado</option>
                        </select>
                    </div>
                </div>
                <div class="bg-white container-default p-3 d-flex flex-column gap-2" style="height: fit-content;">
                    <h5>Seção</h5>
                    <div class="d-flex flex-column">
                        @if(count($secoes)!=0)
                        <label class="label-default" for="nome">Seção do produto</label>
                        <select name="produto[fk_secao]" class="px-3 py-2 input-default w-100">
                            <option value="">Selecione a seção</option>
                            @foreach($secoes as $secao)
                            <option value="{{$secao->id}}">{{$secao->descricao}}</option>
                            @endforeach
                        </select>
                        @else
                        <p class="fs-13">Nenhuma seção cadatrada nesse estabelecimento</p>
                        <a href="/secoes/{{$estabelecimento->id}}/create" class="btn-default btn-large a-button w-100" >Adicionar</p></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 d-flex flex-row-reverse bg-white p-3 gap-3">
        <div class="d-flex flex-row gap-2">
            <a href="/produtos/{{$estabelecimento->id}}" class="btn-default small a-button px-3 py-2 btn-cancel d-flex flex-row gap-2" ><i class="bi bi-x-lg"></i><p class="m-0">Cancelar</p></a>
            <button type="submit" class="btn-default py-2 px-3 small d-flex flex-row gap-2" ><i class="bi bi-floppy"></i><p class="m-0">Salvar</p></button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>

    let tagsArray = [];
    let imagesArray = [];

    document.getElementById('addImageButton').addEventListener('click', function() {
        document.getElementById('images').click();
    });

    document.getElementById('images').addEventListener('change', function(event) {
        const files = event.target.files;
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');

        if (files.length + imagesArray.length > 5) {
            toastr.error('Você só pode selecionar até 5 imagens.');
            return;
        }

        for (let i = 0; i < files.length; i++) {
            imagesArray.push(files[i]);

            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'image-preview-wrapper';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'image-preview';

                const removeBtn = document.createElement('button');
                removeBtn.className = 'remove-image-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', function() {
                    imagePreviewContainer.removeChild(wrapper);
                    imagesArray = imagesArray.filter(f => f !== files[i]);
                });

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                imagePreviewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(files[i]);
        }
    });

    function formatCurrency(value) {
        let cleanedValue = value.replace(/\D/g, '');

        if (cleanedValue === '') return '';

        let numericValue = parseInt(cleanedValue) / 100;

        let formattedValue = numericValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        return `R$ ${formattedValue}`;
    }

    function applyCurrencyFormatting(inputElement, initialValue = '0') {
        inputElement.value = formatCurrency(initialValue);

        inputElement.addEventListener('input', function(event) {
            let input = event.target;
            input.value = formatCurrency(input.value);
        });
    }

    applyCurrencyFormatting(document.getElementById('preco'), '0');
    applyCurrencyFormatting(document.getElementById('preco_oferta'), '0');

    document.getElementById('add_tag').addEventListener('click', function() {

        let tagName = Array.from(document.getElementById('tags').selectedOptions).map(option => option.text);
        let tagId = document.getElementById('tags').value;

        if(!tagId || tagsArray.includes(tagId)){
            return
        }
        
        tagsArray.push(tagId);

        let json = JSON.stringify(tagsArray);

        document.getElementById('tags-produto').value = json;

        if(tagsArray.length ==1){
            let label = document.createElement('label');
            label.className = "label-default";
            label.innerHTML = "Tags selecionadas"
            document.getElementById('tags-select').appendChild(label);
        }

        tagName.forEach(name => {
            let div = document.createElement('div');
            div.className = `d-flex flex-row justify-content-between align-items-center px-2 gap-2 tag_${tagId}`;
            div.innerHTML = `
            <p class="m-0">${name}</p>
            <button type="button" id="${tagId}" class="btn-clean fc-red"><i class="bi bi-trash"></i></button>
        `;

            document.getElementById('tags-select').appendChild(div);
        });
    });


    $(document).on('click', '.btn-clean', function() {

        let tags = document.getElementById('tags-select');
        let tagRemove = tags.querySelector(`.tag_${this.id}`);
        tags.removeChild(tagRemove);

        index = tagsArray.indexOf(this.id);
        tagsArray.splice(index, 1);

        let json = JSON.stringify(tagsArray);

        document.getElementById('tags-produto').value = json;

        if(tagsArray.length == 0){
            labelRemove = tags.querySelector('.label-default');
            tags.removeChild(labelRemove)
        }
    });


    $('#form_produto').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        imagesArray.forEach(image => {
            formData.append('produto[images][]', image);
        });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message, 'Sucesso');
                setTimeout(function() {
                    window.location.href = `/produtos/{{$estabelecimento->id}}`;
                }, 3000);
            },
            error: function(xhr, status, error) {
                if (xhr.status == 409) {
                    toastr.error(xhr.responseJSON.message);
                } else if (xhr.status == 400) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Erro ao cadastrar produto!', 'Erro');
                }
            }
        });
    });
</script>
@endsection