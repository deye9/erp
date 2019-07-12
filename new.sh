if [ true ]; then
ssh -i /Users/andelatsm/.ssh/saas_erp andelatsm@34.65.246.140 '<<EOF
echo "pulling from github"
git pull https://github.com/deye9/erp.git
echo "pulling down current deployment"
sudo docker-compose down
echo "spinning up new deployment"
sudo docker-compose up
EOF
'
fi
