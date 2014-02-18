set :application, "randos1000etangs"
set :domain,      "#{application}.fr"
set :deploy_to,   "/srv/www/#{domain}"
set :app_path,    "public_html"

set :repository,  "#{domain}:/var/repos/#{application}.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

#after "deploy", "deploy:cleanup"