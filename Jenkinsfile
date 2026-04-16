pipeline {
    agent any

    options {
        timestamps()
        timeout(time: 30, unit: 'MINUTES')
    }

    stages {
        stage('Checkout') {
            steps {
                echo '==== Fetching code from GitHub ===='
                checkout scm
                sh 'echo Repository cloned successfully'
                sh 'ls -la'
            }
        }

        stage('Build') {
            steps {
                echo '==== Building containerized application ===='
                sh '''
                    echo "Stopping existing containers..."
                    docker compose -f docker-compose-jenkins.yml down || true

                    echo "Creating app directory..."
                    mkdir -p app
                    cp index.php app/

                    echo "Starting containers..."
                    docker compose -f docker-compose-jenkins.yml up -d
                '''
            }
        }

        stage('Health Check') {
            steps {
                sh 'sleep 10'
                sh 'docker ps | grep notes_app_ci'
            }
        }

        stage('Verify') {
            steps {
                sh 'docker compose -f docker-compose-jenkins.yml ps'
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline succeeded. App running on port 8082.'
        }
        failure {
            echo '❌ Pipeline failed. Stopping containers...'
            sh 'docker compose -f docker-compose-jenkins.yml down || true'
        }
    }
}
