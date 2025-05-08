#!/bin/bash
set -e

# === CONFIGURACIÓ ===
STACK_NAME="webstack"
IMAGE_NAME="webapp-as"
TAR_NAME="webapp-as.tar"
REMOTE_USER="webadmin"
REMOTE_HOST="172.16.56.164"
REMOTE_PATH="/home/webadmin"
REMOTE_PASS="proyecto"

# === PAS 0: Netejar imatge i fitxer antics localment ===
echo "Netejant imatge i tar anteriors..."
docker rmi -f $IMAGE_NAME:latest 2>/dev/null || true
rm -f $TAR_NAME

# === PAS 1: Eliminar l'stack existent ===
echo "Eliminant stack $STACK_NAME..."
docker stack rm $STACK_NAME || true
sleep 10

# === PAS 2: Recompilar la imatge local ===
echo "Recompilant la imatge $IMAGE_NAME..."
docker build --no-cache -t $IMAGE_NAME .

# === PAS 3: Exportar la imatge com a TAR ===
echo "Exportant la imatge com $TAR_NAME..."
docker save $IMAGE_NAME:latest -o $TAR_NAME

# === PAS 4: Eliminar còpia antiga a SV2 (si existeix) ===
echo "Eliminant còpia antiga a $REMOTE_HOST..."
ssh ${REMOTE_USER}@${REMOTE_HOST} "rm -f ${REMOTE_PATH}/${TAR_NAME}"

# === PAS 5: Copiar imatge a SV2 ===
echo "Copiant imatge a $REMOTE_HOST..."
scp $TAR_NAME ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_PATH}/

# === PAS 6: Carregar imatge a SV2 amb sudo ===
echo "Carregant imatge a $REMOTE_HOST amb sudo..."
ssh ${REMOTE_USER}@${REMOTE_HOST} "echo '${REMOTE_PASS}' | sudo -S docker load -i ${REMOTE_PATH}/${TAR_NAME}"

# === PAS 7: Tornar a desplegar l'stack ===
echo "Desplegant stack $STACK_NAME..."
docker stack deploy -c docker-compose.yml $STACK_NAME

echo "Redeploy completat. Tot actualitzat i net!"
