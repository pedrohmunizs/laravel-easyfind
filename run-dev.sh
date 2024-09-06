#!/bin/bash

echo "Iniciando Docker com Sail..."
./vendor/bin/sail up -d

# Verifica se o Docker subiu corretamente
if [ $? -ne 0 ]; then
  exit 1
fi

echo "Iniciando serviços Laravel..."

php artisan reverb:start &
REVERB_PID=$!
echo "Reverb server iniciado com PID $REVERB_PID"

./vendor/bin/sail artisan queue:work --queue=changeStatus,newUser,saveImageEstabelecimento,saveImageProduto,newPedido,default &
QUEUE_PID=$!
echo "Queue worker iniciado com PID $QUEUE_PID"

function cleanup {
    echo "Parando serviços..."
    kill $REVERB_PID
    kill $QUEUE_PID
    echo "Serviços parados."

    ./vendor/bin/sail down
    echo "Docker foi parado."
}

trap cleanup EXIT

wait $REVERB_PID $QUEUE_PID