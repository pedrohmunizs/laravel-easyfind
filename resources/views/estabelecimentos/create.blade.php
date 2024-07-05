<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog create-modal-width" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #222222;">
                <h5 class="modal-title text-white" id="exampleModalLabel">Cadastro de Loja</h5>
                <button type="button" class="rounded border-0 red-color" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x text-white"></i></button>
            </div>
            <div class="modal-body p-4">
                <div class="progress my-3">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form id="form_estabelecimento" action="/estabelecimentos" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div id="step1" class="step d-flex flex-column">
                        <h4 class="my-3">Dados da loja</h4>
                        <div class="d-flex flex-row gap-3 justify-content-between">
                            <div class="d-flex flex-column gap-4">
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="nome">Nome</label>
                                    <input type="text" name="estabelecimento[nome]" class="input-default w-100 px-3 py-2" required>
                                    <div class="invalid-feedback">Por favor, adicione o nome da loja.</div>
                                </div>
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="segmento">Segmento</label>
                                    <select name="estabelecimento[segmento]" id="segmento" class="input-default w-100 px-3 py-2" required>
                                        <option value=""></option>
                                        <option value="Eletrônicos">Eletrônicos</option>
                                        <option value="Informática">Informática</option>
                                        <option value="Mercado">Mercado</option>
                                        <option value="Produtos naturais">Produtos naturais</option>
                                        <option value="Artigos esportivos">Artigos esportivos</option>
                                        <option value="Vestuário">Vestuário</option>
                                        <option value="Decoração">Decoração</option>
                                        <option value="Livraria">Livraria</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecione o segmento da loja.</div>
                                </div>
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="telefone">Número de contato</label>
                                    <input type="text" name="estabelecimento[telefone]" class="input-default w-100 px-3 py-2" required>
                                    <div class="invalid-feedback">Por favor, adicione o número de contato.</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-4">
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="email">Email de contato</label>
                                    <input type="email" name="estabelecimento[email]" class="input-default w-100 px-3 py-2" required>
                                    <div class="invalid-feedback">Por favor, adicione o email de contato.</div>
                                </div>
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="instagram">Link do Instagram</label>
                                    <input type="text" name="estabelecimento[url_instagram]" class="input-default w-100 px-3 py-2" required>
                                    <div class="invalid-feedback">Por favor, adicione o link do Instagram.</div>
                                </div>
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="facebook">Link do Facebook</label>
                                    <input type="text" name="estabelecimento[url_facebook]" class="input-default w-100 px-3 py-2" required>
                                    <div class="invalid-feedback">Por favor, adicione o link do Facebook.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step2" class="step d-none flex-column">
                        <h4 class="my-3">Endereço</h4>
                        <div class="d-flex flex-row gap-3 justify-content-between">
                            <div class="d-flex flex-column gap-4">
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="cep">CEP</label>
                                    <input type="text" name="endereco[cep]" class="input-default w-100 px-3 py-2" id="cep" required>
                                    <div class="invalid-feedback">Por favor, adicione o CEP.</div>
                                </div>
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="numero">Número</label>
                                    <input type="text" name="endereco[numero]" class="input-default w-100 px-3 py-2" required>
                                    <div class="invalid-feedback">Por favor, adicione o número.</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-4">
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="logradouro">Logradouro</label>
                                    <input type="text" name="endereco[logradouro]" class="input-default w-100 px-3 py-2" id="logradouro" required>
                                    <div class="invalid-feedback">Por favor, adicione o logradouro.</div>
                                </div>
                                <div class="form-label-column d-flex flex-column gap-1">
                                    <label class="label-default" for="bairro">Bairro</label>
                                    <input type="text" name="endereco[bairro]" class="input-default w-100 px-3 py-2" id="bairro" required>
                                    <div class="invalid-feedback">Por favor, adicione o bairro.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step3" class="step d-none flex-column">
                        <h4 class="my-3">Horário de atendimento</h4>
                        @php
                            $days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
                        @endphp

                        @foreach($days as $day)
                            <x-day :day="$day" />
                        @endforeach
                    </div>
                    <div id="step4" class="step d-none flex-column">
                        <h4 class="my-3">Imagem da loja</h4>
                        <div class="form-group d-flex justify-content-center">
                            <input type="file" class="form-control-file none" id="image" name="image" required>
                            <div class="invalid-feedback">Por favor, adicione uma imagem da loja.</div>
                            <div class="mt-3">
                                <img id="imagePreview" src="https://via.placeholder.com/150" alt="Prévia da imagem"/>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row gap-4 justify-content-center mt-4">
                        <button type="button" class="btn-default btn-large" onclick="prevStep()">Voltar</button>
                        <button type="button" class="btn-default btn-large" onclick="nextStep()">Avançar</button>
                        <button type="submit" class="btn-default btn-large" id="submitButton" style="display: none;">Finalizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
