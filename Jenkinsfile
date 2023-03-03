pipeline {
    agent any
    stages {
        stage('build') {
            environment {
                UNIX_TIME = sh(returnStdout: true, script: 'date +"%Y_%m_%d_%H_%M_%S"').trim()
                APP_KEY = credentials("photo-app-key")
                APP_URL = credentials("photo-app-url")
                DB_HOST = credentials("photo-db-host")
                DB_PORT = credentials("photo-db-port")
                DB_DATABASE = credentials("photo-db-database")
                DB_USERNAME = credentials("photo-db-username")
                DB_PASSWORD = credentials("photo-db-password")
                MAIL_HOST = credentials("photo-mail-host")
                MAIL_USERNAME = credentials("photo-mail-username")
                MAIL_PASSWORD = credentials("photo-mail-password")
                MAIL_FROM_ADDRESS = credentials("photo-mail-from-address")
                AWS_ACCESS_KEY_ID = credentials("photo-aws-access-key-id")
                AWS_SECRET_ACCESS_KEY = credentials("photo-aws-secret-access-key")
                AWS_BUCKET = credentials("photo-aws-bucket")
            }
            steps {
                sh 'cp .env.example .env'
                sh 'echo APP_KEY=$APP_KEY >> .env'
                sh 'echo APP_URL=$APP_URL >> .env'
                sh 'echo DB_HOST=$DB_HOST >> .env'
                sh 'echo DB_PORT=$DB_PORT >> .env'
                sh 'echo DB_DATABASE=$DB_DATABASE >> .env'
                sh 'echo DB_USERNAME=$DB_USERNAME >> .env'
                sh 'echo DB_PASSWORD=$DB_PASSWORD >> .env'
                sh 'echo MAIL_HOST=$MAIL_HOST >> .env'
                sh 'echo MAIL_USERNAME=$MAIL_USERNAME >> .env'
                sh 'echo MAIL_PASSWORD=$MAIL_PASSWORD >> .env'
                sh 'echo MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS >> .env'
                sh 'echo AWS_ACCESS_KEY_ID=$AWS_ACCESS_KEY_ID >> .env'
                sh 'echo AWS_SECRET_ACCESS_KEY=$AWS_SECRET_ACCESS_KEY >> .env'
                sh 'echo AWS_BUCKET=$AWS_BUCKET >> .env'
                sh 'tar -zcvf /tmp/build.tar.gz .'
                sh 'mv /tmp/build.tar.gz build.tar.gz'
            }
        }
        stage('deploy') {
            environment {
                UNIX_TIME = sh(returnStdout: true, script: 'date +"%Y_%m_%d_%H_%M_%S"').trim()
            }
            steps {
                sshPublisher alwaysPublishFromMaster: true, publishers: [sshPublisherDesc(
                    configName: 'stage-photoalbum',
                    transfers: [
                        sshTransfer(
                            cleanRemote: false,
                            excludes: '',
                            execCommand: "tar -xvf /var/www/$UNIX_TIME/build.tar.gz -C /var/www/$UNIX_TIME/ && \
                                          rm /var/www/$UNIX_TIME/build.tar.gz && \
                                          rm -rf /var/www/$UNIX_TIME/.git && \
                                          rm /var/www/latest && \
                                          ln -s /var/www/$UNIX_TIME /var/www/latest && \
                                          docker restart photoalbum_php && \
                                          docker exec photoalbum_php composer install && \
                                          sudo chown -R www-data:www-data /var/www/latest/vendor && \
                                          sudo chown -R www-data:www-data /var/www/latest/storage && \
                                          docker exec photoalbum_php php artisan migrate --force",
                            execTimeout: 120000,
                            flatten: false,
                            makeEmptyDirs: false,
                            noDefaultExcludes: false,
                            patternSeparator: '[, ]+',
                            remoteDirectory: "$UNIX_TIME",
                            remoteDirectorySDF: false,
                            removePrefix: '',
                            sourceFiles: 'build.tar.gz')],
                usePromotionTimestamp: false,
                useWorkspaceInPromotion: false,
                verbose: false)]
            }
        }
    }
}
