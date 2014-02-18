set :application, "randos.maat8"
set :domain,      "#{application}.fr"
set :deploy_to,   "/srv/www/#{domain}"
set :app_path,    "public_html"

set :repository,  "https://github.com/maat8/mille-etangs.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]

set :use_composer, true

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

#after "deploy", "deploy:cleanup"