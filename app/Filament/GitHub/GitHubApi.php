<?php

namespace App\Filament\GitHub;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class GitHubApi
{
    public function getActivityEventsUser(Model $user): array
    {
        $client = new Client();
        $org = config("app.GitHubOrganization");
        $user_name = $this->getUser($user);
        try {
            $response = $client->get("https://api.github.com/users/{$user_name['login']}/events/orgs/{$org}", [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "Bearer {$user->git_token}",
                    'X-GitHub-Api-Version' => '2022-11-28',
                ],
            ]);
            // Verifique se a resposta foi bem-sucedida (código de status 200)
            if ($response->getStatusCode() === 200) {

                $activity = json_decode($response->getBody(), true);

                return $activity;
            } else {
                // Lida com erros aqui, dependendo do código de status recebido
            }
        } catch (\Exception $e) {
            return $response->getStatusCode();
        }
    }


    public function getRepositoryOrganization(Model $user): array
    {
        $client = new Client();
        $org = config("app.GitHubOrganization");

        try {
            $response = $client->get("https://api.github.com/orgs/{$org}/repos", [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "Bearer {$user->git_token}",
                    'X-GitHub-Api-Version' => '2022-11-28',
                ],
            ]);

            // Verifique se a resposta foi bem-sucedida (código de status 200)
            if ($response->getStatusCode() === 200) {
                $repos = json_decode($response->getBody(), true);
                return $repos;
            } else {
                // Lida com erros aqui, dependendo do código de status recebido

            }
        } catch (\Exception $e) {
            return $response->getStatusCode();
        }
    }


    public function getUser(Model $user): array
    {
        $client = new Client();
        $org = config("app.GitHubOrganization");

        try {
            $response = $client->get("https://api.github.com/user", [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "Bearer {$user->git_token}",
                    'X-GitHub-Api-Version' => '2022-11-28',
                ],
            ]);

            // Verifique se a resposta foi bem-sucedida (código de status 200)
            if ($response->getStatusCode() === 200) {
                $repos = json_decode($response->getBody(), true);
                return $repos;
            } else {
                // Lida com erros aqui, dependendo do código de status recebido

            }
        } catch (\Exception $e) {
            return $response->getStatusCode();
        }
    }

    public function createRepositoryOrganization(Model $user, array $data): array
    {
        $client = new Client();
        $org = config("app.GitHubOrganization");

        try {
            $response = $client->post("https://api.github.com/orgs/{$org}/repos", [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "Bearer {$user->git_token}",
                    'X-GitHub-Api-Version' => '2022-11-28',
                ],
                'data' => [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'homepage' => 'https://github.com',
                    'private' => false,
                    'has_issues' => true,
                    'has_projects' => true,
                    'has_wiki' => true,
                ]
            ]);

            // Verifique se a resposta foi bem-sucedida (código de status 200)
            if ($response->getStatusCode() === 200) {
                $repos = json_decode($response->getBody(), true);
                return $repos;
            } else {
                // Lida com erros aqui, dependendo do código de status recebido

            }
        } catch (\Exception $e) {
            return $response->getStatusCode();
        }
    }

    public function getbranchs(Model $user,string $repository): array
    {
        $client = new Client();
        $org = config("app.GitHubOrganization");

        try {
            $response = $client->post("https://api.github.com/repos/{$org}/{$repository}/branches", [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "Bearer {$user->git_token}",
                    'X-GitHub-Api-Version' => '2022-11-28',
                ],
            ]);

            // Verifique se a resposta foi bem-sucedida (código de status 200)
            if ($response->getStatusCode() === 200) {
                $repos = json_decode($response->getBody(), true);
                return $repos;
            } else {
                // Lida com erros aqui, dependendo do código de status recebido

            }
        } catch (\Exception $e) {
            return $response->getStatusCode();
        }
    }
}
