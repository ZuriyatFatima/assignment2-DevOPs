pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                echo 'Cloning from GitHub...'
                checkout scm
            }
        }

        stage('Stop Old Containers') {
            steps {
                echo 'Cleaning up old CI containers...'
                sh 'docker compose -f docker-compose-jenkins.yml down --remove-orphans || true'
            }
        }

        stage('Build & Start') {
            steps {
                echo 'Starting containerized application...'
                sh 'docker compose -f docker-compose-jenkins.yml up -d --build'
            }
        }

        stage('Verify') {
            steps {
                echo 'Verifying containers are running...'
                sh 'docker ps | grep notes_app_ci'
            }
        }
    }

    post {
        success {
            echo 'Deployment successful! App running on port 8082.'
        }
        failure {
            echo 'Pipeline failed. Check logs above.'
        }
    }
}
