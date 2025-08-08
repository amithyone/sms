#!/bin/bash

echo "🚀 Setting up Git Remote Repository"
echo "=================================="
echo ""
echo "Please choose your Git hosting platform:"
echo "1. GitHub"
echo "2. GitLab" 
echo "3. Bitbucket"
echo "4. Custom URL"
echo ""
read -p "Enter your choice (1-4): " choice

case $choice in
    1)
        echo ""
        echo "📋 GitHub Setup Instructions:"
        echo "1. Go to https://github.com"
        echo "2. Create a new repository named 'faddedsms'"
        echo "3. Copy the repository URL (e.g., https://github.com/yourusername/faddedsms.git)"
        echo ""
        read -p "Enter your GitHub repository URL: " repo_url
        ;;
    2)
        echo ""
        echo "📋 GitLab Setup Instructions:"
        echo "1. Go to https://gitlab.com"
        echo "2. Create a new repository named 'faddedsms'"
        echo "3. Copy the repository URL (e.g., https://gitlab.com/yourusername/faddedsms.git)"
        echo ""
        read -p "Enter your GitLab repository URL: " repo_url
        ;;
    3)
        echo ""
        echo "📋 Bitbucket Setup Instructions:"
        echo "1. Go to https://bitbucket.org"
        echo "2. Create a new repository named 'faddedsms'"
        echo "3. Copy the repository URL (e.g., https://bitbucket.org/yourusername/faddedsms.git)"
        echo ""
        read -p "Enter your Bitbucket repository URL: " repo_url
        ;;
    4)
        echo ""
        read -p "Enter your custom repository URL: " repo_url
        ;;
    *)
        echo "❌ Invalid choice. Exiting."
        exit 1
        ;;
esac

if [ -n "$repo_url" ]; then
    echo ""
    echo "🔗 Adding remote repository..."
    git remote add origin "$repo_url"
    
    echo ""
    echo "📤 Pushing to remote repository..."
    git branch -M main
    git push -u origin main
    
    echo ""
    echo "✅ Success! Your code has been pushed to the remote repository."
    echo "🌐 You can now view your code at the repository URL."
else
    echo "❌ No repository URL provided. Exiting."
    exit 1
fi
