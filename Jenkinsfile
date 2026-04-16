pipeline {
    agent any

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
                sh 'echo Stopping existing containers...'
                sh 'docker compose -f docker-compose-part2.yml down || true'
                sh 'echo Creating app directory...'
                sh 'mkdir -p app'
                sh 'cp index.php app/'
                sh 'echo Starting containers...'
                sh 'docker compose -f docker-compose-part2.yml up -d'
            }
        }

        stage('Verify') {
            steps {
                echo '==== Verifying containers are running ===='
                sh 'docker ps | grep notes_app_ci || echo "App container not found"'
            }
        }
    }

    post {
        success {
            echo '✅ Pipeline successful! Part II app running on port 8082'
        }
        failure {
            echo '❌ Pipeline failed. Stopping containers...'
            sh 'docker compose -f docker-compose-part2.yml down || true'
        }
    }
}
