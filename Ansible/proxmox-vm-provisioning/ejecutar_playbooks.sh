#!/bin/bash

export PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
export HOME=/home/ansible
export USER=ansible

eval "$(ssh-agent -s)" >/dev/null 2>&1
ssh-add /home/ansible/.ssh/id_rsa >/dev/null 2>&1


LOGFILE="/home/ansible/ansible_minuto.log"
echo "--- $(date): Ejecutando playbooks ---" >> "$LOGFILE"

for playbook in /home/ansible/proxmox-vm-provisioning/playbooks/*.yml; do
  echo "Iniciando $playbook" >> "$LOGFILE"
  /usr/bin/ansible-playbook "$playbook" >> "$LOGFILE" 2>&1
done
