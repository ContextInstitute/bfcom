# Bright Future Commons

Bright Future Commons (BFCom) is intended to serve as an intranet for [intentional networks](http://blog.kumu.io/building-intentional-networks-that-drive-impact-part-1/). [Context Institute](http://www.context.org/about/) is developing it as a platform to provide web support for the [Bright Future Network](http://www.context.org/about/plans/bright-future-network-initial-vision/) (BFNet).

It is a fork of CUNY’s [Commons In A Box](http://commonsinabox.org/), which is built on [BuddyPress](https://buddypress.org/) and [bbPress](https://bbpress.org/), which are in turn built on [WordPress](https://wordpress.org/). Like Commons In A Box, Bright Future Commons is a theme and an associated set of plugins— some our own and some developed and maintained by others. Our value-add is in the integration and customization. This is a user-driven project focused on meeting the needs of the Bright Future Network, but we expect BFCom will be useful for others as well.

While the commercial social media, like Facebook and Twitter, focus on lots of quick, almost random, interactions, BFCom is focused on meaningful collaboration and conversation in a non-commercial setting – like meeting in someone’s home rather than meeting in a marketplace. We feel BFCom has the potential for meaningfully accelerating cultural change by enabling better self-organized collaboration.

The basic design is for a site that supports many subgroups drawn from a membership pool that shares broad common interests and perspectives. The platform supports effective collaboration in those subgroups and robust cross-communication between groups and among individual members. Access to the site requires registration. For the Bright Future Network, members of the site will primarily be graduates of the [Bright Future Now course](http://www.context.org/about/plans/journey-deeper-into-the-planetary-era/).

Building on Commons In A Box, each subgroup has its own forum (from bbPress), its own blog (from WordPress multisite) and its own wiki-like docs. Each member can message either publicly (twitter-like) or privately.

## Participation

Interested? We’d love to have your involvement on any of the following three levels:

* Public – Everyone has access to this github repo and to our [public Google Drive](https://drive.google.com/drive/u/2/folders/0B4UY32-vtSy1ZUV6OWVUUWF4Yms). We recommend you start with [Project Table of Contents](https://docs.google.com/document/d/16OPzH__T6D7kgpmBtvCV_gcYkEETSv9EQ2tDkzvgJuw/) on the G-Drive and feel free to leave comments here as issues.

* Active Team – If you are interested in actively commenting on the project on an ongoing basis, we can give you access to our test site, to our Slack channel and to commenting on our Google Docs. If this is something you’d like to explore, send an email to [rgilman@context.org](mailto:rgilman@context.org).

* Core Team – This is the group that is doing more than commenting, including designing, coding and documenting. If this is something you’d like to explore, again, send an email to [rgilman@context.org](mailto:rgilman@context.org).

## Road Map

### Version 1

#### Redo UI

* *stronger focus on content and people; less on branding, nav and site data* – With only registered users and a commitment to focused communications we want to reduce visual distraction as much as possible.

* *home page becomes personal dashboard* – Each registered user will be able to follow other users and groups that are of interest. The user’s home page is where all these feeds come together for scanning and choosing where to go deeper.

* *section home pages become section dashboards* – The site has sections for People, Groups, Resources and Blogs. The home page for each section provides updates for activity within that section for discovering new material from people and groups the user is not yet following.

* *remain responsive* – The CBOX theme (that we are adapting) is already responsive. We will build on that and, where we can, enhance it.

#### Change and add functions

* *follow rather than friend* – Within an intentional network everyone is already a friend, at least in the Facebook sense. Following, which can be asymmetrical, is more useful in enabling each user to customize the information they want to see.

* *permission system to meet BFNet needs* – Commons In A Box already provides quite a bit of access control of its four channels of communications: blogs, forums, messages and docs. Each subgroup in a site using BFCom will be able to choose who has access to the content in each channel.

In addition, there will be at least three groups of users:

* Graduates of Bright Future Now, who are full BFNet members, will be the bulk of the users and who will have access to most of the site
	
* Current participants in a Bright Future Now course, who will have access to only their subgroup/cohort and course related materials
	
* Guests, who can be invited to join a single subgroup that has been organized by BFNet members and who will have limited access to the rest of the site.

### Version 2

#### Refine UI based on use

#### Change and add functions

* *Keywords* – Create a curated system of keywords/tags that can be applied to groups, people and blog posts and that users can follow.

* *Events* – Add the ability to schedule and track everything from working meetings within a group to public events

* *Offers and asks* – This is an important aspect of mutual support within a network. We will add it in a way that fits within the constraints required for nonprofit organizations.

* *Better search* – Search is still one of the weaker functions in WordPress. We will add a more robust capability that still maintains privacy within the network.

## Status

As a project, BFCom got its start in mid July 2016. Since then we have been gathering a team, doing prototyping and developing design guidelines (please see the Wiki for a [timeline](https://github.com/ContextInstitute/bfcom/wiki/Timeline) and our [public Google Drive](https://drive.google.com/drive/u/2/folders/0B4UY32-vtSy1ZUV6OWVUUWF4Yms) for details). 

As of Thanksgiving 2016, we’re just starting into coding. The files in the repo are the wp-content from our test site and, other than a few additional plugins, have no customization beyond a standard Commons In A Box/CBOX-theme setup. They’re here to assist project members with creating their own local development setup.

## License

In keeping with the software it is built on, Bright Future Commons has a [GPL v3](https://www.gnu.org/licenses/quick-guide-gplv3.en.html) license.
