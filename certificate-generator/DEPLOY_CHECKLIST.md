# Deployment Checklist

## Before Deployment:
- [ ] Update GitHub repository URL in README.md
- [ ] Update app URL in .env file
- [ ] Test locally with `composer install`
- [ ] Run `php init.php` to test database
- [ ] Generate test certificate locally

## GitHub Setup:
- [ ] Initialize git: `git init`
- [ ] Add files: `git add .`
- [ ] Commit: `git commit -m "Initial commit"`
- [ ] Create GitHub repository
- [ ] Add remote: `git remote add origin YOUR_REPO_URL`
- [ ] Push: `git push -u origin main`

## Render Deployment:
- [ ] Login to Render Dashboard
- [ ] Click "New +" > "Web Service"
- [ ] Connect GitHub repository
- [ ] Verify render.yaml settings
- [ ] Click "Create Web Service"
- [ ] Wait for deployment (3-5 minutes)
- [ ] Test live URL

## Post-Deployment:
- [ ] Test certificate generation
- [ ] Test certificate verification
- [ ] Update live URL in README
- [ ] Share with client
